<?php
  function run_query($query) {
    include('config.php');
    $mysqli = new mysqli($db_host, $db_user, $db_pw, $db_database);
    /* check connection */
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
    $result = $mysqli->query($query);
    $mysqli->close();
    return $result;
  }

  function get_num_fillups() {
    $result = run_query("SELECT count(*) FROM gas_log");
    return $result->fetch_row()[0];
  }

  function get_net_price() {
    $result = run_query("SELECT sum(totalprice) FROM gas_log");
    return $result->fetch_row()[0];
  }

  function get_net_gas() {
    $result = run_query("SELECT sum(volume) FROM gas_log");
    return $result->fetch_row()[0];
  }

  function get_last_odometer() {
    $result = run_query("SELECT max(odometer) FROM gas_log");
    return $result->fetch_row()[0];
  }

  function get_min_price_per_gallon() {
    $result = run_query("SELECT min(pricepergallon) FROM gas_log");
    return $result->fetch_row()[0];
  }

  function get_max_price_per_gallon() {
    $result = run_query("SELECT max(pricepergallon) FROM gas_log");
    return $result->fetch_row()[0];
  }

  function display_table_head() {
    $headers = array('Date',
                     'Brand',
                     'Price/Gal',
                     'Gallons',
                     'Cost',
                     'Odometer',
                     'Miles/Gal',
                    );
    echo '              <tr>';
    foreach($headers as $header) {
      switch($header) {
        case "Date": echo '<th class="date">'; break;
        case "Brand": echo '<th class="brand">'; break;
        default: echo '<th>';
      }
      echo $header.'</th>';
    }
    echo "</tr>\n";
  }

  function display_note($note) {
    echo '              <tr class="note"><td colspan="7" class="summary">'.$note."</td></tr>\n";
    display_table_head();
  }
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
  <head>
    <title>genetik's gas log</title>
    <link rel="stylesheet" media="screen" href="default.css" type="text/css" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="Author" content="Brian J. Creasy">
  </head>
  <body>
    <div id="container">
      <div id="header">
        <h1>genetik's gas log</h1>
        <p>This is a study I'm conducting in which I'm going to keep track of the gas I put into my car and how much money is spent on it.</p>
      </div>
      <div id="content">
        <h2>2005 Honda Civic LX (manual trans.)</h2>
        <p id="car-mileage">EPA Gas Mileage Estimate: 32 City / 38 Highway</p>
        <p id="car-fueltanksize">Fuel Tank Capacity: 13.2gal</p>

        <div id="data">
          <table>
            <thead>
<?php display_table_head(); ?>
            </thead>
            <tbody>
<?php
  $result = run_query("SELECT * FROM gas_log ORDER BY date ASC");

  while ($row = $result->fetch_array()) {
    if (($last_date < "2005-01-05 00:00:00") && ("2005-01-05 00:00:00" < $row['date'])) {
      display_note("Began working at Slippery Rock School District (82mi round trip, plus travel during)");
    }

    if (($last_date < "2005-10-15 00:00:00") && ("2005-10-15 00:00:00" < $row['date'])) {
      display_note("Began working at Collaborative Fusion (36mi round trip)");
    }

    if (($last_date < "2006-09-01 00:00:00") && ("2006-09-01 00:00:00" < $row['date'])) {
      display_note("Began living in Squirrel Hill (limited driving)");
    }

    if (($last_date < "2011-11-03 00:00:00") && ("2011-11-03 00:00:00" < $row['date'])) {
      display_note("Began working at Starmount (10.5mi round trip)");
    }

    if (($last_date < "2012-11-24 00:00:00") && ("2012-11-24 00:00:00" < $row['date'])) {
      display_note("Switched to synthetic motor oil");
    }

    $last_date = $row['date'];

    echo '              <tr>';
    echo '<td class="date">'.$row['date'].'</td>';
    echo '<td class="brand">'.$row['brand'].'<sup>'.$row['octane'].'</sup></td>';
    echo '<td>$'.number_format($row['pricepergallon'], 3).'</td>';
    echo '<td>'.number_format($row['volume'], 3).'</td>';
    echo '<td>$'.number_format($row['totalprice'], 2).'</td>';
    echo '<td>'.number_format($row['odometer'], 0, '.', ',').'</td>';
    echo '<td>'.number_format(($row['odometer'] - $last_odometer) / $row['volume'], 2).'</td>';
    echo "</tr>\n";

    $last_odometer = $row['odometer'];
  }
  $result->free();
?>
            </tbody>
          </table>
          <div id="stats">
            <dl>
              <dt class="first">Number of Fill-ups</dt><dd class="first"><?php echo get_num_fillups(); ?></dd>
              <dt>Total Money Spent On Gas</dt><dd><?php echo "$" . round(get_net_price(), 2); ?></dd>
              <dt>Total Gallons of Gas</dt><dd><?php echo get_net_gas(); ?></dd>
              <dt>Average Gas Mileage</dt><dd><?php echo round(get_last_odometer() / get_net_gas(), 2); ?></dd>
              <dt>Average Miles per Tank</dt><dd><?php echo round((get_last_odometer() / get_num_fillups()), 2); ?></dd>
              <dt>Average Price Per Fill-up</dt><dd><? echo "$" . round(get_net_price() / get_num_fillups(), 2); ?></dd>
              <dt>Average Price/Gal.</dt><dd><?php echo "$" . (get_min_price_per_gallon() + get_max_price_per_gallon()) / 2; ?></dd>
              <dt>Min Price Per Gallon</dt><dd><? echo "$" . get_min_price_per_gallon(); ?></dd>
              <dt>Max Price Per Gallon</dt><dd><? echo "$" . get_max_price_per_gallon(); ?></dd>
            </dl>
          </div>
        </div>
      </div>
    </div>
    <script type="text/javascript">

      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-37433033-1']);
      _gaq.push(['_trackPageview']);

      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();

    </script>
  </body>
</html>
