<?php
$chart = new Highchart();
$chart->chart->renderTo = "container";
$chart->chart->type = "column";
$chart->title->text = utf8_decode("Servicios Más Vendidos");

$chart->xAxis->categories = array($this->datos[0]['XPRODUCTO'],$this->datos[1]['XPRODUCTO'],
        $this->datos[2]['XPRODUCTO'],$this->datos[3]['XPRODUCTO'],$this->datos[4]['XPRODUCTO']);

$chart->yAxis->min = 0;
$chart->yAxis->title->text = "Ventas en S/.";
$chart->legend->layout = "vertical";
$chart->legend->backgroundColor = "#FFFFFF";
$chart->legend->align = "left";
$chart->legend->verticalAlign = "top";
$chart->legend->x = 100;
$chart->legend->y = 70;
$chart->legend->floating = 1;
$chart->legend->shadow = 1;

$chart->tooltip->formatter = new HighchartJsExpr("function() {
    return '' + this.x +': S/. '+ this.y +'';}");

$chart->plotOptions->column->pointPadding = 0.2;
$chart->plotOptions->column->borderWidth = 0;

$chart->series[] = array('name' => "Dinero Por Ventas de Servicios",
                         'data' => array((float)$this->datos[0]['VALOR'],(float)$this->datos[1]['VALOR'], 
                             (float)$this->datos[2]['VALOR'], (float)$this->datos[3]['VALOR'], 
                             (float)$this->datos[4]['VALOR']));

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
