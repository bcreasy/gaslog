var nano = require('nano')('http://localhost:5984');
var gaslog = nano.db.use('gaslog');

nano.db.get('gaslog', function(err, body) {
	if (!err) {
		console.log(body);
	}
});
