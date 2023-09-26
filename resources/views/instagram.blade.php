<!DOCTYPE html>
<html>
<head>
	<title>Instafeed on Your Website</title>
	<style type="text/css">
		a img{ 
			width: 25%;
		}
	</style>
</head>
<body>
	<h1 style="text-align: center">Show Instagram Feed on your Website</h1>
    	<div id="instafeed-container"></div>



	<script src="https://cdn.jsdelivr.net/gh/stevenschobert/instafeed.js@2.0.0rc1/src/instafeed.min.js"></script>
	<script type="text/javascript">
	var userFeed = new Instafeed({
		get: 'user',
		target: "instafeed-container",
    	resolution: 'low_resolution',
		accessToken: 'IGQWRQb1ZAmay1NY0M3ME9aSUJwUXE5akZAuY2d0eG8zeVFWQ2lkVWNRdXVpdEVVUDZABVFhzMldWWFZAOc3lIYTZAhV1JCckhOYU9pRUo4alFRejFDZAHNzX1Q3MzBCZAEZAob3ZAITWYwd2VmX2RnOFEyRVJ5ZA19HUmVXcTgZD'
	});
	userFeed.run();
	</script>
</body>
</html>