<?php
$chart = new Highchart();
$chart->chart->renderTo = "container";
$chart->chart->type = "line";
$chart->title->text = utf8_decode("Ventas Mensuales de Aquinos Grafica Integral");

$chart->xAxis->categories = array("Ene", "Feb", "Mar", "Abr", "May", "Jun",
                                  "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");

$chart->yAxis->min = 0;
$chart->yAxis->title->text = "Ventas en S/.";
$chart->legend->layout = "vertical";
$chart->legend->backgroundColor = "#FFFFFF";
$chart->legend->align = "left";
$chart->legend->verticalAlign = "top";
$chart->legend->x = 100;
$chart->legend->y = 30;
$chart->legend->floating = 1;
$chart->legend->shadow = 1;

$chart->tooltip->formatter = new HighchartJsExpr("function() {
    return '' + this.x +': S/. '+ this.y +'';}");

$chart->plotOptions->line->pointPadding = 0.2;
$chart->plotOptions->line->borderWidth = 0;

$chart->series[] = array('name' => "Dinero Por Ventas por Mes",
                         'data' => array((float)$this->datos[0]['CANTIDAD'],(float)$this->datos[1]['CANTIDAD'], 
                             (float)$this->datos[2]['CANTIDAD'], (float)$this->datos[3]['CANTIDAD'], 
                             (float)$this->datos[4]['CANTIDAD'], (float)$this->datos[5]['CANTIDAD'],
                             (float)$this->datos[6]['CANTIDAD'], (float)$this->datos[7]['CANTIDAD'], 
                             (float)$this->datos[8]['CANTIDAD'], (float)$this->datos[9]['CANTIDAD'], 
                             (float)$this->datos[10]['CANTIDAD'], (float)$this->datos[11]['CANTIDAD']));

?>

<html>
  <head>
    <title>Ventas</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <?php
      foreach ($chart->getScripts() as $script) {
         echo '<script type="text/javascript" src="' . $script . '"></script>';
      }
    ?>
  </head>
  <body>
    <div id="container"></div>
    <script type="text/javascript">
    <?php
      echo $chart->render("chart1");
    ?>
    </script>
  </body>
</html>
