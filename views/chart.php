<?= $header ?>  
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">

      // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'When');
        data.addColumn('number', 'Gigs');
        data.addRows([
			<? foreach ($result as $key => $value): ?>
				<? print "['{$key}', $value],"; ?>
				<? print "\n"; ?>
			<?	endforeach;	?>
        ]);

        // Set chart options
        var options = {'title': '<?= addslashes($chart_title) ?>',
                       'width': window.innerWidth * 0.8,
                       'height': window.innerHeight * 0.8};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
  </head>

  <body>
    <!--Div that will hold the pie chart-->
    <div id="chart_div"></div>
<?= $footer ?>