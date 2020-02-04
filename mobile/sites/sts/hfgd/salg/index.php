<?
require($_SERVER["DOCUMENT_ROOT"]."/mobile/headers.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("HFGD - Hvordan Fanden Går Det?");
?>
<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawVisualization);

      function drawVisualization() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
          ['Måneder', 'Aygo', 'Yaris', 'Auris', 'Corolla', 'RAV¤', 'GNS'],
          ['2019/05',  5,      12,         4,             1,           4,      4],
          ['2019/06',  6,      15,        6,             3,          4,      5],
          ['2019/07',  3,      11,        8,             4,           6,      6],
          ['2019/08',  8,      18,        9,             3,           8,      4],
          ['2019/09',  11,      7,         11,             5,          5,      5]
        ]);

        var options = {
          title : 'Salg modeller pr mdr',
          vAxis: {title: 'Antal'},
          hAxis: {title: 'Måned'},
          seriesType: 'bars',
          series: {5: {type: 'line'}}        };

        var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="chart_div" style="width: 100%; height: 100%;"></div>
  </body>
</html>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php")?>