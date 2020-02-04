<?
require($_SERVER["DOCUMENT_ROOT"]."/mobile/headers.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("HFGD - Hvordan Fanden Går Det?");
?>
<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Job', 'Timer'],
          ['Mekanisk',  1400],
          ['Oprydning',  160],
          ['Tomgang', 34]
        ]);

      var options = {
        legend: 'none',
        pieSliceText: 'label',
        title: 'Tilstedeværende Timer',
        pieStartAngle: 100,
      };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="piechart" style="width: 100%; height: 100%;"></div>
  </body>
</html>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php")?>