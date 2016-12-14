<?php
    
    include('../framework/registry.class.php');
    include('../framework/Console.php');
    include('../model/db.class.php');
    include('conf/Settings.php');
    include('../framework/rss/wToolRSS.php');
    include('../model/pagination.class.php');
    include_once "../lib/highcharts-php/highcharts.php";
    
    $site_path = realpath(dirname(__FILE__));
    define ('__SITE_PATH', $site_path);
    
    /*** a new registry object ***/
    $registry = new registry;
    
    /*** create the settings registry object ***/
    $registry->settings = Settings::get();
    
    $registry->console = Console::get($registry->settings);
    
    /*** create the database registry object ***/
    $registry->db = db::get($registry->settings, $registry->console);
    
    foreach ($registry->settings->js_libs as $lib) echo "<script type=text/javascript src='".$registry->settings->js_path.$lib."'></script>\n\t";
    
    //get array from CSV file
    function get_array() {

        $file = fopen('facebook.csv', 'r');

        while (($line = fgetcsv($file,'',';')) !== FALSE) {

          $array_data[] = $line;

        }

        fclose($file);

        unset($array_data[0]);

        return $array_data;

        }
    //formatting stats to use w/ highcharts
    function get_lines() {

        $array = get_array();
        
        foreach($array as $key => $value)
        {
            $lines[] = array(
                'name' => $key,
                'data' => $value
            );
        }
        
        return $lines;
    }
        
        // Start by adding a new reference object
        // and adding some configuration for the chart
        $oHighcharts = new Highcharts(new HighchartsChart('container', HighchartsChart::SERIES_TYPE_LINE));

        // Title typeof HighchartsTitle
        $oHighcharts->title = new HighchartsTitle('Competitor comparison');

        // Description of xAxis
        $oHighcharts->xAxis->categories = array('Date', 'New Fans', 'Unlikes', 'Page Impression', 'Page Impression (paid)', 'Page Impression (viral)', 'page impressions (page post)', 'page imp. (others)', 'Page imp. (fans)', 'Page Imp. (mention)', 'Stories Created', 'Stories Creators', 'Stories (page post)', 'Stories (User Post)', 'Stories (Other)', 'Stories (Fan)', 'Stories (Mention)');

        // Options for yAxis
        $oHighcharts->yAxis->min = 0;
        $oHighcharts->yAxis->setTitle(new HighchartsTitle('Last 30 days'));

        $oHighcharts->legend->reversed = false;

        // The formatter is a javascript callback
        $oHighcharts->tooltip->formatter = "function() {
            return this.series.name +': '+ this.y +' ('+ Math.round(this.percentage)+'%)';
        }";

        // If stacking, choose normal
        //$oHighcharts->plotOptions->column->stacking = HighchartsPlotOptionsColumn::HIGHCHARTS_PLOT_OPTIONS_COLUMN_STACKING_PERCENT;

        // These are your data
        $data = get_lines();
        
        foreach($data as $value)
        {
            print_r($value);
            echo '<br />';
            $oHighcharts->series->addSerie(new HighchartsSerie($value['name'], $value['data']));
        }

        // Render chart
        $content[] = $oHighcharts->render();
?>
