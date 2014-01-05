var nano = require('nano')('http://localhost:5984');
var gaslog = nano.db.use('gaslog');

gaslog.view('basic', 'basic', function(err, body) {
  if (!err) {
    body.rows.forEach(function(doc) {
      console.log(doc.key);
      console.log(doc.value);
    });
  }
});
