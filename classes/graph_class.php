<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of graph_class
 *
 * @author vanhelsing
 */
include_once 'funzioni.php'; 

class graph_class {

    var $colori;

    function graph_class() {
        $this->colori = "'#00B0F0', '#0066ff', '#7030A0', '#FF9900', '#33CC33', '#BF0000', '#003B89', '#7F7F7F', '#D9D9D9', '#a6c96a'";
    }

    function get_colori() {
        return $this->colori;
    }

    function set_colori($lista_colori) {
        $this->colori = $lista_colori;
    }

    function print_graph_tput_old($matrice, $ordinata = "", $minimo = "", $unita_misura = "", $titolo = "", $sottotitolo = "") {
       
        $asse_x = array_column($matrice, 'time_end');
        #print_r($asse_x);
        
        $serie['Tput_L1'] = array_column($matrice, 'tput_tot_size');         
        $serie['Tput_L1_net'] = array_column($matrice, 'tput_tot_eff');

        $chiavi[0] = 'Tput_L1';
        $chiavi[1] = 'Tput_L1_net';
        #print_r($chiavi);
        
        ?>
        <script src="vendors/Highcharts-6.0.4/code/highcharts.js"></script>
        <script src="vendors/Highcharts-6.0.4/code/modules/series-label.js"></script>
        <script src="vendors/Highcharts-6.0.4/code/modules/exporting.js"></script>
        <script src="vendors/Highcharts-6.0.4/code/modules/boost.js"></script>

        <br>
        <div id="container_tput" ></div>


        <script type="text/javascript">
            Highcharts.chart('container_tput', {

            chart: {
            zoomType: 'xy'
            },
                    /*
                     boost: {
                     useGPUTranslations: true
                     },
                     */

                    title: {
                    text: 'Throughput'
                    },
                    subtitle: {
                    text: 'Qxdm (0xB173) LTE PDSCH'
                    },
                    /*  
                     xAxis: {
                     min: 0,
                     max: 120,
                     ordinal: false
                     },
                     units: [[
                     'millisecond', // unit name
                     [1, 2, 5, 10, 20, 25, 50, 100, 200, 500] // allowed multiples
                     ], [
                     'second',
                     [1, 2, 5, 10, 15, 30]
                     ],    
                     */

                    xAxis: [{

                    title: {
                    text: 'Second'
                    },
        <?php
        #$asse_x = $serie[$chiavi[0]];
        echo "categories: [";
        foreach ($asse_x as $key => $value) {
            $sec_val = round($value/1000,2);
            #$sec_val = $value;
            echo "'$sec_val'";
            if ($key < count($asse_x) - 1)
                echo ",";
        }
        echo "]";
        ?>
                    }],
                    yAxis: {
                    title: {
                    text: 'bit/sec'
                    }
                    },
                    legend: {
                    layout: 'vertical',
                            align: 'right',
                            verticalAlign: 'middle'
                    },
                    tooltip: {
                    headerFormat: '<b>{series.name}</b><br>',
                            formatter: function() {
                            return 'time: ' + this.x + 'sec<br>Tput: ' + this.y + 'bit/sec';
                            }

                    },
                    /*    
                     tooltip: {
                     formatter: function() {
                     return '<b>' + this.series.name + '</b><br/>' +
                     this.x + ': ' + this.y + '<?php echo $unita_misura; ?>';
                     }
                     },
                     */
                    plotOptions: {
                    spline: {
                    marker: {
                    enabled: true
                    }
                    }
                    },
      <?php
        echo "series: [";
        
        for ($riga = 0; $riga < count($chiavi); $riga++) {
            echo "{name: '";
            echo $chiavi[$riga] . "',
        data: [";

            for ($colonna = 0; $colonna < count($serie[$chiavi[$riga]]); $colonna++) {
                echo $serie[$chiavi[$riga]][$colonna];
                if ($colonna < count($serie[$chiavi[$riga]]))
                    echo ",";
            }
            echo "]}";
            if ($riga < count($serie[$chiavi[$riga]]) - 1)
                echo",";
        }
        echo" ],";
        ?>

            responsive: {
            rules: [{
            condition: {
            maxWidth: 500
            },
                    chartOptions: {
                    legend: {
                    layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                    }
                    }
            }]
            }

            });</script>
            <?php
        }
    
    function print_graph_tput($matrice, $ordinata = "", $minimo = "", $unita_misura = "", $titolo = "", $sottotitolo = "") {
        #$punti = count($matrice); 
        #$chiavi = array_keys($matrice[0]);
        $asse_x = array_column($matrice, 'time_end');
        
        $serie['TPut_PCELL'] = array_column(array_column($matrice, 'TPut_tot'), 'PCELL');         
        $serie['TPut_eff_PCELL'] = array_column(array_column($matrice, 'TPut_eff'), 'PCELL');
        
        $serie['TPut_Tot'] = $serie['TPut_PCELL'];
        $serie['TPut_Tot_eff'] = $serie['TPut_eff_PCELL'];
                   
        if (recursive_return_array_value_by_key('SCC1', $matrice)) {
            $serie['TPut_SCC1'] = array_column(array_column($matrice, 'TPut_tot'), 'SCC1');  
            $serie['TPut_eff_SCC1'] = array_column(array_column($matrice, 'TPut_eff'), 'SCC1');
            /////TPut totale
            for($i=0; $i<count($serie['TPut_SCC1']); $i++){
                $serie['TPut_Tot'][$i] = $serie['TPut_Tot'][$i]+$serie['TPut_SCC1'][$i];
                $serie['TPut_Tot_eff'][$i] = $serie['TPut_Tot_eff'][$i]+$serie['TPut_eff_SCC1'][$i];
            }

        }
        if (recursive_return_array_value_by_key('SCC2', $matrice)) {
            $serie['TPut_SCC2'] = array_column(array_column($matrice, 'TPut_tot'), 'SCC2');
            $serie['TPut_eff_SCC2'] = array_column(array_column($matrice, 'TPut_eff'), 'SCC2');
            /////TPut totale
            for($i=0; $i<count($serie['TPut_SCC1']); $i++){
                $serie['TPut_Tot'][$i] = $serie['TPut_Tot'][$i]+$serie['TPut_SCC2'][$i];
                $serie['TPut_Tot_eff'][$i] = $serie['TPut_Tot_eff'][$i]+$serie['TPut_eff_SCC2'][$i];
            }                     
        }
        
      
        $chiavi = array_reverse(array_keys($serie));
        #echo'<pre>';
        #print_r($chiavi);
        #print_r($serie); 
        #echo'</pre>';
        ?>
        <script src="vendors/Highcharts-6.0.4/code/highcharts.js"></script>
        <script src="vendors/Highcharts-6.0.4/code/modules/series-label.js"></script>
        <script src="vendors/Highcharts-6.0.4/code/modules/exporting.js"></script>
        <script src="vendors/Highcharts-6.0.4/code/modules/boost.js"></script>

        <br>
        <div id="container_tput"></div>


        <script type="text/javascript">
            Highcharts.chart('container_tput', {

            chart: {
            zoomType: 'xy'
            },
                    /*
                     boost: {
                     useGPUTranslations: true
                     },
                     */

                    title: {
                    text: 'Throughput Scheduled Average '
                    },
                    subtitle: {
                    text: 'Qxdm (0xB173) LTE PDSCH'
                    },
                    /*  
                     xAxis: {
                     min: 0,
                     max: 120,
                     ordinal: false
                     },
                     units: [[
                     'millisecond', // unit name
                     [1, 2, 5, 10, 20, 25, 50, 100, 200, 500] // allowed multiples
                     ], [
                     'second',
                     [1, 2, 5, 10, 15, 30]
                     ],    
                     */

                    xAxis: [{

                    title: {
                    text: 'Second'
                    },
        <?php
        
        echo "categories: [";
        foreach ($asse_x as $key => $value) {
            $sec_val = round($value/1000,2);
            #$sec_val = $value;
            echo "'$sec_val'";
            if ($key < count($asse_x) - 1)
                echo ",";
        }
        echo "]";
        ?>
                    }],
                    yAxis: {
                    title: {
                    text: 'bit/sec'
                    }
                    },
                    legend: {
                    layout: 'vertical',
                            align: 'right',
                            verticalAlign: 'middle'
                    },
                    tooltip: {
                    headerFormat: '<b>{series.name}</b><br>',
                            formatter: function() {
                            return 'time: ' + this.x + 'sec<br>bit/sec: ' + this.y + '';
                            }

                    },
                    /*    
                     tooltip: {
                     formatter: function() {
                     return '<b>' + this.series.name + '</b><br/>' +
                     this.x + ': ' + this.y + '<?php echo $unita_misura; ?>';
                     }
                     },
                     */
                    plotOptions: {
                    spline: {
                    marker: {
                    enabled: true
                    }
                    }
                    },
        <?php
        echo "series: [";

        for ($riga = 0; $riga < count($chiavi); $riga++) {
            echo "{name: '";
            echo $chiavi[$riga] . "',
        data: [";

            for ($colonna = 0; $colonna < count($serie[$chiavi[$riga]]); $colonna++) {
                echo $serie[$chiavi[$riga]][$colonna];
                if ($colonna < count($serie[$chiavi[$riga]]))
                    echo ",";
            }
            echo "]}";
            if ($riga < count($serie[$chiavi[$riga]]) - 1)
                echo",";
        }
        echo" ],";
        ?>

            responsive: {
            rules: [{
            condition: {
            maxWidth: 500
            },
                    chartOptions: {
                    legend: {
                    layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                    }
                    }
            }]
            }

            });</script>
            <?php
        }
    
    function media_tput($matrice){
        
        $asse_x = array_column($matrice, 'time_end');
        
        $serie['TPut_PCELL'] = array_column(array_column($matrice, 'TPut_tot'), 'PCELL');         
        $serie['TPut_eff_PCELL'] = array_column(array_column($matrice, 'TPut_eff'), 'PCELL');
        
        $serie['TPut_Tot'] = $serie['TPut_PCELL'];
        $serie['TPut_Tot_eff'] = $serie['TPut_eff_PCELL'];
                   
        if (recursive_return_array_value_by_key('SCC1', $matrice)) {
            $serie['TPut_SCC1'] = array_column(array_column($matrice, 'TPut_tot'), 'SCC1');  
            $serie['TPut_eff_SCC1'] = array_column(array_column($matrice, 'TPut_eff'), 'SCC1');
            /////TPut totale
            for($i=0; $i<count($serie['TPut_SCC1']); $i++){
                $serie['TPut_Tot'][$i] = $serie['TPut_Tot'][$i]+$serie['TPut_SCC1'][$i];
                $serie['TPut_Tot_eff'][$i] = $serie['TPut_Tot_eff'][$i]+$serie['TPut_eff_SCC1'][$i];
            }

        }
        if (recursive_return_array_value_by_key('SCC2', $matrice)) {
            $serie['TPut_SCC2'] = array_column(array_column($matrice, 'TPut_tot'), 'SCC2');
            $serie['TPut_eff_SCC2'] = array_column(array_column($matrice, 'TPut_eff'), 'SCC2');
            /////TPut totale
            for($i=0; $i<count($serie['TPut_SCC1']); $i++){
                $serie['TPut_Tot'][$i] = $serie['TPut_Tot'][$i]+$serie['TPut_SCC2'][$i];
                $serie['TPut_Tot_eff'][$i] = $serie['TPut_Tot_eff'][$i]+$serie['TPut_eff_SCC2'][$i];
            }                     
        }
        
      
        $chiavi = array_keys($serie);
        
        
        
    }    
        
    function print_graph_tput_real($matrice, $msec_scala, $ordinata = "", $minimo = "", $unita_misura = "", $titolo = "", $sottotitolo = "") {
        #$punti = count($matrice); 
        #$chiavi = array_keys($matrice[0]);
        #$asse_x = array_column($matrice, 'time_end');
        $asse_x = array_column($matrice, 'time_real');
        
        $serie['TPutReal_PCELL'] = array_column(array_column($matrice, 'TPutReal_tot'), 'PCELL');         
        $serie['TPutReal_eff_PCELL'] = array_column(array_column($matrice, 'TPutReal_eff'), 'PCELL');
        
        $serie['TPut_Tot'] = $serie['TPutReal_PCELL'];
        $serie['TPut_Tot_eff'] = $serie['TPutReal_eff_PCELL'];
                   
        if (recursive_return_array_value_by_key('SCC1', $matrice)) {
            $serie['TPutReal_SCC1'] = array_column(array_column($matrice, 'TPutReal_tot'), 'SCC1');  
            $serie['TPutReal_eff_SCC1'] = array_column(array_column($matrice, 'TPutReal_eff'), 'SCC1');
            /////TPut totale
            for($i=0; $i<count($serie['TPutReal_SCC1']); $i++){
                $serie['TPut_Tot'][$i] = $serie['TPut_Tot'][$i]+$serie['TPutReal_SCC1'][$i];
                $serie['TPut_Tot_eff'][$i] = $serie['TPut_Tot_eff'][$i]+$serie['TPutReal_eff_SCC1'][$i];
            } 
            #$serie['TPut_tot'] = $serie['TPut_tot'] + $serie['TPut_SCC1'];
            #$serie['TPut_tot_eff'] = $serie['TPut_tot_eff'] + $serie['TPut_eff_SCC1'];
        }
        if (recursive_return_array_value_by_key('SCC2', $matrice)) {
            $serie['TPutReal_SCC2'] = array_column(array_column($matrice, 'TPutReal_tot'), 'SCC2');
            $serie['TPutReal_eff_SCC2'] = array_column(array_column($matrice, 'TPutReal_eff'), 'SCC2');
            /////TPut totale
            for($i=0; $i<count($serie['TPutReal_SCC1']); $i++){
                $serie['TPut_Tot'][$i] = $serie['TPut_Tot'][$i]+$serie['TPutReal_SCC2'][$i];
                $serie['TPut_Tot_eff'][$i] = $serie['TPut_Tot_eff'][$i]+$serie['TPutReal_eff_SCC2'][$i];
            }                    
        }
        
      
        $chiavi = array_reverse(array_keys($serie));
        
        #print_r($chiavi);
        #print_r($serie); 
        ?>
        <script src="vendors/Highcharts-6.0.4/code/highcharts.js"></script>
        <script src="vendors/Highcharts-6.0.4/code/modules/series-label.js"></script>
        <script src="vendors/Highcharts-6.0.4/code/modules/exporting.js"></script>
        <script src="vendors/Highcharts-6.0.4/code/modules/boost.js"></script>

        <br>
        <div id="container_tputreal"></div>


        <script type="text/javascript">
            Highcharts.chart('container_tputreal', {

            chart: {
            zoomType: 'xy'
            },
                    /*
                     boost: {
                     useGPUTranslations: true
                     },
                     */

                    title: {
                    text: 'Throughput Real '
                    },
                    subtitle: {
                    text: 'Qxdm (0xB173) LTE PDSCH'
                    },
                    /*  
                     xAxis: {
                     min: 0,
                     max: 120,
                     ordinal: false
                     },
                     units: [[
                     'millisecond', // unit name
                     [1, 2, 5, 10, 20, 25, 50, 100, 200, 500] // allowed multiples
                     ], [
                     'second',
                     [1, 2, 5, 10, 15, 30]
                     ],    
                     */

                    xAxis: [{

                    title: {
                    text: 'Second'
                    },
        <?php
        
        echo "categories: [";
        foreach ($asse_x as $key => $value) {
            #$sec_val = round($value/1000,2);
            $sec_val = $value;
            echo "'$sec_val'";
            if ($key < count($asse_x) - 1)
                echo ",";
        }
        echo "]";
        ?>
                    }],
                    yAxis: {
                    title: {
                    text: 'bit/sec'
                    }
                    },
                    legend: {
                    layout: 'vertical',
                            align: 'right',
                            verticalAlign: 'middle'
                    },
                    tooltip: {
                    headerFormat: '<b>{series.name}</b><br>',
                            formatter: function() {
                            return 'time: ' + this.x + 'sec<br>bit/sec: ' + this.y + '';
                            }

                    },
                    /*    
                     tooltip: {
                     formatter: function() {
                     return '<b>' + this.series.name + '</b><br/>' +
                     this.x + ': ' + this.y + '<?php echo $unita_misura; ?>';
                     }
                     },
                     */
                    plotOptions: {
                    spline: {
                    marker: {
                    enabled: true
                    }
                    }
                    },
        <?php
        echo "series: [";

        for ($riga = 0; $riga < count($chiavi); $riga++) {
            echo "{name: '";
            echo $chiavi[$riga] . "',
        data: [";

            for ($colonna = 0; $colonna < count($serie[$chiavi[$riga]]); $colonna++) {
                echo $serie[$chiavi[$riga]][$colonna];
                if ($colonna < count($serie[$chiavi[$riga]]))
                    echo ",";
            }
            echo "]}";
            if ($riga < count($serie[$chiavi[$riga]]) - 1)
                echo",";
        }
        echo" ],";
        ?>

            responsive: {
            rules: [{
            condition: {
            maxWidth: 500
            },
                    chartOptions: {
                    legend: {
                    layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                    }
                    }
            }]
            }

            });</script>
            <?php
        }
    
    function print_graph_tput_real2($matrice, $msec_scala, $ordinata = "", $minimo = "", $unita_misura = "", $titolo = "", $sottotitolo = "") {
        #$punti = count($matrice); 
        #$chiavi = array_keys($matrice[0]);
        $asse_x = array_column($matrice, 'time_end');
        
        $serie['TPutReal_PCELL'] = array_column(array_column($matrice, 'TPutReal_tot'), 'PCELL');
        if (recursive_return_array_value_by_key('SCC1', $matrice)) {
            $serie['TPutReal_SCC1'] = array_column(array_column($matrice, 'TPutReal_tot'), 'SCC1');     
        }
        if (recursive_return_array_value_by_key('SCC2', $matrice)) {
            $serie['TPutReal_SCC2'] = array_column(array_column($matrice, 'TPutReal_tot'), 'SCC2');
        }
        
        if (recursive_return_array_value_by_key('SCC1', $matrice)) {
            $serie['TPutReal_eff_SCC1'] = array_column(array_column($matrice, 'TPutReal_eff'), 'SCC1');     
        }
        if (recursive_return_array_value_by_key('SCC2', $matrice)) {
            $serie['TPutReal_eff_SCC2'] = array_column(array_column($matrice, 'TPutReal_eff'), 'SCC2');
        }
        
      
        $chiavi = array_keys($serie);
        
        print_r($chiavi);
        print_r($serie); 
        ?>
        <script src="vendors/Highcharts-6.0.4/code/highcharts.js"></script>
        <script src="vendors/Highcharts-6.0.4/code/modules/series-label.js"></script>
        <script src="vendors/Highcharts-6.0.4/code/modules/exporting.js"></script>
        <script src="vendors/Highcharts-6.0.4/code/modules/boost.js"></script>

<br>
        <div id="container_tputreal"></div>

        <script type="text/javascript">
            Highcharts.chart('container_tputreal', {

            chart: {
            zoomType: 'xy'
            },
                    /*
                     boost: {
                     useGPUTranslations: true
                     },
                     */

                    title: {
                    text: 'container_tputreal'
                    },
                    subtitle: {
                    text: 'Qxdm (0xB173) LTE PDSCH'
                    },
                    /*  
                     xAxis: {
                     min: 0,
                     max: 120,
                     ordinal: false
                     },
                     units: [[
                     'millisecond', // unit name
                     [1, 2, 5, 10, 20, 25, 50, 100, 200, 500] // allowed multiples
                     ], [
                     'second',
                     [1, 2, 5, 10, 15, 30]
                     ],    
                     */

                    xAxis: [{

                    title: {
                    text: 'Second'
                    },
        <?php
        
        echo "categories: [";
        foreach ($asse_x as $key => $value) {
            $sec_val = round($value/1000,2);
            #$sec_val = $value;
            echo "'$sec_val'";
            if ($key < count($asse_x) - 1)
                echo ",";
        }
        echo "]";
        ?>
                    }],
                    yAxis: {
                    title: {
                    text: 'Scheduling time (%)'
                    }
                    },
                    legend: {
                    layout: 'vertical',
                            align: 'right',
                            verticalAlign: 'middle'
                    },
                    tooltip: {
                    headerFormat: '<b>{series.name}</b><br>',
                            formatter: function() {
                            return 'time: ' + this.x + 'sec<br>scheduling time: ' + this.y + '%';
                            }

                    },
                    /*    
                     tooltip: {
                     formatter: function() {
                     return '<b>' + this.series.name + '</b><br/>' +
                     this.x + ': ' + this.y + '<?php echo $unita_misura; ?>';
                     }
                     },
                     */
                    plotOptions: {
                    spline: {
                    marker: {
                    enabled: true
                    }
                    }
                    },
        <?php
        echo "series: [";

        for ($riga = 0; $riga < count($chiavi); $riga++) {
            echo "{name: '";
            echo $chiavi[$riga] . "',
        data: [";

            for ($colonna = 0; $colonna < count($serie[$chiavi[$riga]]); $colonna++) {
                $percent_val = round($serie[$chiavi[$riga]][$colonna]/$msec_scala*100,2);
                #echo $serie[$chiavi[$riga]][$colonna];
                echo $percent_val;
                if ($colonna < count($serie[$chiavi[$riga]]))
                    echo ",";
            }
            echo "]}";
            if ($riga < count($serie[$chiavi[$riga]]) - 1)
                echo",";
        }
        echo" ],";
        ?>

            responsive: {
            rules: [{
            condition: {
            maxWidth: 500
            },
                    chartOptions: {
                    legend: {
                    layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                    }
                    }
            }]
            }

            });</script>
            <?php
        }
    
    
    function print_graph_tput_sched($matrice, $ordinata = "", $minimo = "", $unita_misura = "", $titolo = "", $sottotitolo = "") {
        #$punti = count($matrice); 
        #$chiavi = array_keys($matrice[0]);
/*{"0":
{"0":
{"time_range":155,
"assex":28714509,
"tput_tot":5.1612903225806,
"tput_eff":5.1612903225806,
"tput_pcell":5.1612903225806,
"tput_scc1":0,
"tput_scc2":0,
"tput_pcell_eff":5.1612903225806,
"tput_scc1_eff":0,
"tput_scc2_eff":0},
 * 
 */
        $asse_x = array_column($matrice, 'assex');
        
        $serie['tput_tot'] = array_column($matrice, 'tput_tot');   
        $serie['tput_eff'] = array_column($matrice, 'tput_eff'); 
        $serie['tput_pcell'] = array_column($matrice, 'tput_pcell'); 
        $serie['tput_scc1'] = array_column($matrice, 'tput_scc1'); 
        $serie['tput_scc2'] = array_column($matrice, 'tput_scc2'); 
        #$serie['tput_pcell_eff'] = array_column($matrice, 'tput_pcell_eff'); 
        #$serie['tput_scc1_eff'] = array_column($matrice, 'tput_scc1_eff'); 
        #$serie['tput_scc2_eff'] = array_column($matrice, 'tput_scc2_eff'); 
/*    
        if (recursive_return_array_value_by_key('SCC1', $matrice)) {
            $serie['TPutSched_SCC1'] = array_column(array_column($matrice, 'TPutSched_tot'), 'SCC1');  
            $serie['TPutSched_eff_SCC1'] = array_column(array_column($matrice, 'TPutSched_eff'), 'SCC1');
        }
        if (recursive_return_array_value_by_key('SCC2', $matrice)) {
            $serie['TPutSched_SCC2'] = array_column(array_column($matrice, 'TPutSched_tot'), 'SCC2');
            $serie['TPutSched_eff_SCC2'] = array_column(array_column($matrice, 'TPutSched_eff'), 'SCC2');
        }
 * 
 */
        
      
        $chiavi = array_keys($serie);
        
        #print_r($chiavi);
        #print_r($serie); 
        ?>
        <script src="vendors/Highcharts-6.0.4/code/highcharts.js"></script>
        <script src="vendors/Highcharts-6.0.4/code/modules/series-label.js"></script>
        <script src="vendors/Highcharts-6.0.4/code/modules/exporting.js"></script>
        <script src="vendors/Highcharts-6.0.4/code/modules/boost.js"></script>

        <br>
        <div id="container_tputsched"></div>


        <script type="text/javascript">
            Highcharts.chart('container_tputsched', {
    chart: {
        type: 'spline'
    },
    title: {
        text: 'Snow depth at Vikjafjellet, Norway'
    },
    subtitle: {
        text: 'Irregular time data in Highcharts JS'
    },
    xAxis: {
        type: 'datetime',
        dateTimeLabelFormats: { // don't display the dummy year
            month: '%e. %b',
            year: '%b'
        },
        title: {
            text: 'Date'
        }
    },
    yAxis: {
        title: {
            text: 'Snow depth (m)'
        },
        min: 0
    },
    tooltip: {
        headerFormat: '<b>{series.name}</b><br>',
        pointFormat: '{point.x:%e. %b}: {point.y:.2f} m'
    },

    plotOptions: {
        spline: {
            marker: {
                enabled: true
            }
        }
    },

    series: [{
        name: 'Winter 2012-2013',
        // Define the data points. All series have a dummy year
        // of 1970/71 in order to be compared on the same x axis. Note
        // that in JavaScript, months start at 0 for January, 1 for February etc.
        data: [
            [Date.UTC(1970, 9, 21), 0],
            [Date.UTC(1970, 10, 4), 0.28],
            [Date.UTC(1970, 10, 9), 0.25],
            [Date.UTC(1970, 10, 27), 0.2],
            [Date.UTC(1970, 11, 2), 0.28],
            [Date.UTC(1970, 11, 26), 0.28],
            [Date.UTC(1970, 11, 29), 0.47],
            [Date.UTC(1971, 0, 11), 0.79],
            [Date.UTC(1971, 0, 26), 0.72],
            [Date.UTC(1971, 1, 3), 1.02],
            [Date.UTC(1971, 1, 11), 1.12],
            [Date.UTC(1971, 1, 25), 1.2],
            [Date.UTC(1971, 2, 11), 1.18],
            [Date.UTC(1971, 3, 11), 1.19],
            [Date.UTC(1971, 4, 1), 1.85],
            [Date.UTC(1971, 4, 5), 2.22],
            [Date.UTC(1971, 4, 19), 1.15],
            [Date.UTC(1971, 5, 3), 0]
        ]
    }, {
        name: 'Winter 2013-2014',
        data: [
            [Date.UTC(1970, 9, 29), 0],
            [Date.UTC(1970, 10, 9), 0.4],
            [Date.UTC(1970, 11, 1), 0.25],
            [Date.UTC(1971, 0, 1), 1.66],
            [Date.UTC(1971, 0, 10), 1.8],
            [Date.UTC(1971, 1, 19), 1.76],
            [Date.UTC(1971, 2, 25), 2.62],
            [Date.UTC(1971, 3, 19), 2.41],
            [Date.UTC(1971, 3, 30), 2.05],
            [Date.UTC(1971, 4, 14), 1.7],
            [Date.UTC(1971, 4, 24), 1.1],
            [Date.UTC(1971, 5, 10), 0]
        ]
    }, {
        name: 'Winter 2014-2015',
        data: [
            [Date.UTC(1970, 10, 25), 0],
            [Date.UTC(1970, 11, 6), 0.25],
            [Date.UTC(1970, 11, 20), 1.41],
            [Date.UTC(1970, 11, 25), 1.64],
            [Date.UTC(1971, 0, 4), 1.6],
            [Date.UTC(1971, 0, 17), 2.55],
            [Date.UTC(1971, 0, 24), 2.62],
            [Date.UTC(1971, 1, 4), 2.5],
            [Date.UTC(1971, 1, 14), 2.42],
            [Date.UTC(1971, 2, 6), 2.74],
            [Date.UTC(1971, 2, 14), 2.62],
            [Date.UTC(1971, 2, 24), 2.6],
            [Date.UTC(1971, 3, 2), 2.81],
            [Date.UTC(1971, 3, 12), 2.63],
            [Date.UTC(1971, 3, 28), 2.77],
            [Date.UTC(1971, 4, 5), 2.68],
            [Date.UTC(1971, 4, 10), 2.56],
            [Date.UTC(1971, 4, 15), 2.39],
            [Date.UTC(1971, 4, 20), 2.3],
            [Date.UTC(1971, 5, 5), 2],
            [Date.UTC(1971, 5, 10), 1.85],
            [Date.UTC(1971, 5, 15), 1.49],
            [Date.UTC(1971, 5, 23), 1.08]
        ]
    }]
});

            

       </script>
            <?php
        }
    
    function print_graph_tput_sched_bkp($matrice, $ordinata = "", $minimo = "", $unita_misura = "", $titolo = "", $sottotitolo = "") {
        #$punti = count($matrice); 
        #$chiavi = array_keys($matrice[0]);
/*{"0":
{"0":
{"time_range":155,
"assex":28714509,
"tput_tot":5.1612903225806,
"tput_eff":5.1612903225806,
"tput_pcell":5.1612903225806,
"tput_scc1":0,
"tput_scc2":0,
"tput_pcell_eff":5.1612903225806,
"tput_scc1_eff":0,
"tput_scc2_eff":0},
 * 
 */
        $asse_x = array_column($matrice, 'assex');
        
        $serie['tput_tot'] = array_column($matrice, 'tput_tot');   
        $serie['tput_eff'] = array_column($matrice, 'tput_eff'); 
        $serie['tput_pcell'] = array_column($matrice, 'tput_pcell'); 
        $serie['tput_scc1'] = array_column($matrice, 'tput_scc1'); 
        $serie['tput_scc2'] = array_column($matrice, 'tput_scc2'); 
        #$serie['tput_pcell_eff'] = array_column($matrice, 'tput_pcell_eff'); 
        #$serie['tput_scc1_eff'] = array_column($matrice, 'tput_scc1_eff'); 
        #$serie['tput_scc2_eff'] = array_column($matrice, 'tput_scc2_eff'); 
/*    
        if (recursive_return_array_value_by_key('SCC1', $matrice)) {
            $serie['TPutSched_SCC1'] = array_column(array_column($matrice, 'TPutSched_tot'), 'SCC1');  
            $serie['TPutSched_eff_SCC1'] = array_column(array_column($matrice, 'TPutSched_eff'), 'SCC1');
        }
        if (recursive_return_array_value_by_key('SCC2', $matrice)) {
            $serie['TPutSched_SCC2'] = array_column(array_column($matrice, 'TPutSched_tot'), 'SCC2');
            $serie['TPutSched_eff_SCC2'] = array_column(array_column($matrice, 'TPutSched_eff'), 'SCC2');
        }
 * 
 */
        
      
        $chiavi = array_keys($serie);
        
        #print_r($chiavi);
        #print_r($serie); 
        ?>
        <script src="vendors/Highcharts-6.0.4/code/highcharts.js"></script>
        <script src="vendors/Highcharts-6.0.4/code/modules/series-label.js"></script>
        <script src="vendors/Highcharts-6.0.4/code/modules/exporting.js"></script>
        <script src="vendors/Highcharts-6.0.4/code/modules/boost.js"></script>

        <br>
        <div id="container_tputsched"></div>


        <script type="text/javascript">
            Highcharts.chart('container_tputsched', {

            chart: {
            zoomType: 'x'
            },
                    
                     boost: {
                     useGPUTranslations: true
                     },
                     

                    title: {
                    text: 'Throughput Scheduled'
                    },
                    subtitle: {
                    text: 'Qxdm (0xB173) LTE PDSCH'
                    },
                    /*  
                     xAxis: {
                     min: 0,
                     max: 120,
                     ordinal: false
                     },
                     units: [[
                     'millisecond', // unit name
                     [1, 2, 5, 10, 20, 25, 50, 100, 200, 500] // allowed multiples
                     ], [
                     'second',
                     [1, 2, 5, 10, 15, 30]
                     ],    
                     */

                    xAxis: [{
                    //type: 'datetime'        
                    title: {
                    text: 'Second'
                    },
     
                    //min: 0,
                    //max: 120,
        <?php
        reset($asse_x);
        $asse_zero =$asse_x[0]; 
        echo "categories: [";
        foreach ($asse_x as $key => $value) {
            #$sec_val = $value;
            #$sec_val = round($value/1000,3);
            //normalizzo l'asse x partendo da t=0 e converto in sec
            $sec_val = round(($value - $asse_zero)/1000,3);
            echo "'$sec_val'";
            if ($key < count($asse_x) - 1)
                echo ",";
        }
        echo "]";
        ?>
                    }],
                    yAxis: {
                    title: {
                    text: 'bit/sec'
                    }
                    },
                    legend: {
                    layout: 'vertical',
                            align: 'right',
                            verticalAlign: 'middle'
                    },
                    tooltip: {
                    headerFormat: '<b>{series.name}</b><br>',
                            formatter: function() {
                            return 'time: ' + this.x + 'sec<br>bit/sec: ' + this.y + '';
                            }

                    },
                    /*    
                     tooltip: {
                     formatter: function() {
                     return '<b>' + this.series.name + '</b><br/>' +
                     this.x + ': ' + this.y + '<?php echo $unita_misura; ?>';
                     }
                     },
                     */
                    plotOptions: {
                    spline: {
                    marker: {
                    enabled: true
                    }
                    }
                    },
        <?php
        echo "series: [";

        for ($riga = 0; $riga < count($chiavi); $riga++) {
            echo "{name: '";
            echo $chiavi[$riga] . "',
        data: [";

            for ($colonna = 0; $colonna < count($serie[$chiavi[$riga]]); $colonna++) {
                echo $serie[$chiavi[$riga]][$colonna]*1000;
                if ($colonna < count($serie[$chiavi[$riga]]))
                    echo ",";
            }
            echo "]}";
            if ($riga < count($serie[$chiavi[$riga]]) - 1)
                echo",";
        }
        echo" ],";
        ?>

            responsive: {
            rules: [{
            condition: {
            maxWidth: 500
            },
                    chartOptions: {
                    legend: {
                    layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                    }
                    }
            }]
            }

            });</script>
            <?php
    }
       
    function print_graph_tput_sch_avg($matrice, $ordinata = "", $minimo = "", $unita_misura = "", $titolo = "", $sottotitolo = "") {
        #$punti = count($matrice); 
        #$chiavi = array_keys($matrice[0]);
        
        /*
    }
{"0":{
"time_end":59741765,
"assex":59741600,
"tput_tot":83.83,
"tput_eff":83.83,
"tput_pcell":83.83,
"tput_scc1":0,
"tput_scc2":0,
"tput_pcell_eff":83.83,
"tput_scc1_eff":0,
"tput_scc2_eff":0},
 */
        $asse_x = array_column($matrice, 'time_end');
        
        $serie['tput_tot'] = array_column($matrice, 'tput_tot');   
        $serie['tput_eff'] = array_column($matrice, 'tput_eff'); 
        $serie['tput_pcell'] = array_column($matrice, 'tput_pcell'); 
        $serie['tput_scc1'] = array_column($matrice, 'tput_scc1'); 
        $serie['tput_scc2'] = array_column($matrice, 'tput_scc2'); 
        #$serie['tput_pcell_eff'] = array_column($matrice, 'tput_pcell_eff'); 
        #$serie['tput_scc1_eff'] = array_column($matrice, 'tput_scc1_eff'); 
        #$serie['tput_scc2_eff'] = array_column($matrice, 'tput_scc2_eff'); 
/*    
        if (recursive_return_array_value_by_key('SCC1', $matrice)) {
            $serie['TPutSched_SCC1'] = array_column(array_column($matrice, 'TPutSched_tot'), 'SCC1');  
            $serie['TPutSched_eff_SCC1'] = array_column(array_column($matrice, 'TPutSched_eff'), 'SCC1');
        }
        if (recursive_return_array_value_by_key('SCC2', $matrice)) {
            $serie['TPutSched_SCC2'] = array_column(array_column($matrice, 'TPutSched_tot'), 'SCC2');
            $serie['TPutSched_eff_SCC2'] = array_column(array_column($matrice, 'TPutSched_eff'), 'SCC2');
        }
 * 
 */
        
      
        $chiavi = array_keys($serie);
        
        #print_r($chiavi);
        #print_r($serie); 
        ?>
        <script src="vendors/Highcharts-6.0.4/code/highcharts.js"></script>
        <script src="vendors/Highcharts-6.0.4/code/modules/series-label.js"></script>
        <script src="vendors/Highcharts-6.0.4/code/modules/exporting.js"></script>
        <script src="vendors/Highcharts-6.0.4/code/modules/boost.js"></script>

        <br>
        <div id="container_tputschd_avg"></div>


        <script type="text/javascript">
            Highcharts.chart('container_tputschd_avg', {

            chart: {
            zoomType: 'x'
            },
                    
                     boost: {
                     useGPUTranslations: true
                     },
                     

                    title: {
                    text: 'Throughput Scheduled Avg'
                    },
                    subtitle: {
                    text: 'Qxdm (0xB173) LTE PDSCH'
                    },
                    /*  
                     xAxis: {
                     min: 0,
                     max: 120,
                     ordinal: false
                     },
                     units: [[
                     'millisecond', // unit name
                     [1, 2, 5, 10, 20, 25, 50, 100, 200, 500] // allowed multiples
                     ], [
                     'second',
                     [1, 2, 5, 10, 15, 30]
                     ],    
                     */

                    xAxis: [{
                    //type: 'datetime'        
                    title: {
                    text: 'Second'
                    },
     
                    //min: 0,
                    //max: 120,
        <?php
        reset($asse_x);
        $asse_zero =$asse_x[0]; 
        echo "categories: [";
        foreach ($asse_x as $key => $value) {
            #$sec_val = $value;
            #$sec_val = round($value/1000,3);
            //normalizzo l'asse x partendo da t=0 e converto in sec
            $sec_val = round(($value - $asse_zero)/1000,3);
            echo "'$sec_val'";
            if ($key < count($asse_x) - 1)
                echo ",";
        }
        echo "]";
        ?>
                    }],
                    yAxis: {
                    title: {
                    text: 'bit/sec'
                    }
                    },
                    legend: {
                    layout: 'vertical',
                            align: 'right',
                            verticalAlign: 'middle'
                    },
                    tooltip: {
                    headerFormat: '<b>{series.name}</b><br>',
                            formatter: function() {
                            return 'time: ' + this.x + 'sec<br>bit/sec: ' + this.y + '';
                            }

                    },
                    /*    
                     tooltip: {
                     formatter: function() {
                     return '<b>' + this.series.name + '</b><br/>' +
                     this.x + ': ' + this.y + '<?php echo $unita_misura; ?>';
                     }
                     },
                     */
                    plotOptions: {
                    spline: {
                    marker: {
                    enabled: true
                    }
                    }
                    },
        <?php
        echo "series: [";

        for ($riga = 0; $riga < count($chiavi); $riga++) {
            echo "{name: '";
            echo $chiavi[$riga] . "',
        data: [";

            for ($colonna = 0; $colonna < count($serie[$chiavi[$riga]]); $colonna++) {
                echo $serie[$chiavi[$riga]][$colonna]*1000;
                if ($colonna < count($serie[$chiavi[$riga]]))
                    echo ",";
            }
            echo "]}";
            if ($riga < count($serie[$chiavi[$riga]]) - 1)
                echo",";
        }
        echo" ],";
        ?>

            responsive: {
            rules: [{
            condition: {
            maxWidth: 500
            },
                    chartOptions: {
                    legend: {
                    layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                    }
                    }
            }]
            }

            });</script>
            <?php
    }
          
    function print_graph_mcs($matrice, $ordinata = "", $minimo = "", $unita_misura = "", $titolo = "", $sottotitolo = "") {
        #$punti = count($matrice); 
        #$chiavi = array_keys($matrice[0]);
        $asse_x = array_column($matrice, 'time_end');
        
        $serie['MCS_1_PCELL'] = array_column(array_column($matrice, 'MCS_1'), 'PCELL');         
        $serie['MCS_2_PCELL'] = array_column(array_column($matrice, 'MCS_2'), 'PCELL');
        $serie['MCS_tot_PCELL'] = array_column(array_column($matrice, 'MCS_tot'), 'PCELL');
               
        if (recursive_return_array_value_by_key('SCC1', $matrice)) {
            $serie['MCS_1_SCC1'] = array_column(array_column($matrice, 'MCS_1'), 'SCC1');  
            $serie['MCS_2_SCC1'] = array_column(array_column($matrice, 'MCS_2'), 'SCC1');
            $serie['MCS_tot_SCC1'] = array_column(array_column($matrice, 'MCS_tot'), 'SCC1'); 
        }
        if (recursive_return_array_value_by_key('SCC2', $matrice)) {
            $serie['MCS_1_SCC2'] = array_column(array_column($matrice, 'MCS_1'), 'SCC2');
            $serie['MCS_2_SCC2'] = array_column(array_column($matrice, 'MCS_2'), 'SCC2');
            $serie['MCS_tot_SCC2'] = array_column(array_column($matrice, 'MCS_tot'), 'SCC2');
        }
        
      
        $chiavi = array_keys($serie);
        
        #print_r($chiavi);
        #print_r($serie); 
        ?>
        <script src="vendors/Highcharts-6.0.4/code/highcharts.js"></script>
        <script src="vendors/Highcharts-6.0.4/code/modules/series-label.js"></script>
        <script src="vendors/Highcharts-6.0.4/code/modules/exporting.js"></script>
        <script src="vendors/Highcharts-6.0.4/code/modules/boost.js"></script>

        <br>
        <div id="container_mcs"></div>


        <script type="text/javascript">
            Highcharts.chart('container_mcs', {

            chart: {
            zoomType: 'xy'
            },
                    /*
                     boost: {
                     useGPUTranslations: true
                     },
                     */

                    title: {
                    text: 'MCS'
                    },
                    subtitle: {
                    text: 'Qxdm (0xB173) LTE PDSCH'
                    },
                    /*  
                     xAxis: {
                     min: 0,
                     max: 120,
                     ordinal: false
                     },
                     units: [[
                     'millisecond', // unit name
                     [1, 2, 5, 10, 20, 25, 50, 100, 200, 500] // allowed multiples
                     ], [
                     'second',
                     [1, 2, 5, 10, 15, 30]
                     ],    
                     */

                    xAxis: [{

                    title: {
                    text: 'Second'
                    },
        <?php
        
        echo "categories: [";
        foreach ($asse_x as $key => $value) {
            $sec_val = round($value/1000,2);
            #$sec_val = $value;
            echo "'$sec_val'";
            if ($key < count($asse_x) - 1)
                echo ",";
        }
        echo "]";
        ?>
                    }],
                    yAxis: {
                    title: {
                    text: 'MCs number'
                    }
                    },
                    legend: {
                    layout: 'vertical',
                            align: 'right',
                            verticalAlign: 'middle'
                    },
                    tooltip: {
                    headerFormat: '<b>{series.name}</b><br>',
                            formatter: function() {
                            return 'time: ' + this.x + 'sec<br>n°: ' + this.y + '';
                            }

                    },
                    /*    
                     tooltip: {
                     formatter: function() {
                     return '<b>' + this.series.name + '</b><br/>' +
                     this.x + ': ' + this.y + '<?php echo $unita_misura; ?>';
                     }
                     },
                     */
                    plotOptions: {
                    spline: {
                    marker: {
                    enabled: true
                    }
                    }
                    },
        <?php
        echo "series: [";

        for ($riga = 0; $riga < count($chiavi); $riga++) {
            echo "{name: '";
            echo $chiavi[$riga] . "',
        data: [";

            for ($colonna = 0; $colonna < count($serie[$chiavi[$riga]]); $colonna++) {
                echo $serie[$chiavi[$riga]][$colonna];
                if ($colonna < count($serie[$chiavi[$riga]]))
                    echo ",";
            }
            echo "]}";
            if ($riga < count($serie[$chiavi[$riga]]) - 1)
                echo",";
        }
        echo" ],";
        ?>

            responsive: {
            rules: [{
            condition: {
            maxWidth: 500
            },
                    chartOptions: {
                    legend: {
                    layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                    }
                    }
            }]
            }

            });</script>
            <?php
        }

    function print_graph($matrice_risultati, $lista_nomi, $ordinata, $minimo, $unita_misura, $titolo, $sottotitolo, $size = "12") {
            if (count($lista_nomi) > 1) {
                ?>

            <script type="text/javascript">
                var chart;
                $(document).ready(function() {
                chart = new Highcharts.Chart({
                chart: {
                marginTop: 50,
                        marginLeft: 80,
                        renderTo: 'container',
                        defaultSeriesType: 'line',
                        type: 'line',
                        zoomType: 'xy'
                },
                        credits: {
                        enabled: false
                        },
                        colors: ['#00B0F0', '#0066ff', '#7030A0', '#FF9900', '#33CC33', '#BF0000', '#003B89', '#7F7F7F', '#D9D9D9', '#a6c96a'],
                        title: {
                        text: ''
                        },
                        xAxis: [{
                        labels: {
                        style: {
                        fontSize: '14px',
                                fontWeight: 'bold'
                        }
                        },
            <?php
            echo "categories: [";
            $lista_nomi_visualizzati = _nome_mese($lista_nomi);
            if (count($lista_nomi_visualizzati) > 1) {
                foreach ($lista_nomi_visualizzati as $key => $value) {
                    echo "'$value'";
                    if ($key < count($lista_nomi_visualizzati) - 1)
                        echo ",";
                }
            } else
// print_r (_nome_mese($lista_nomi));
                echo "<th>$lista_nomi_visualizzati</th>";
            echo "]";
            ?>
                        }],
                        yAxis: {
                        marginTop: 10,
                                title: {
                                align: 'high',
                                        offset: - 60,
                                        rotation: 0,
                                        y: - 20,
                                        text: '<?php echo $ordinata; ?>'
                                }, <?php echo $minimo; ?>
                        labels: {
                        formatter: function() {
                        return this.value + '<?php echo $unita_misura; ?>';
                        }, style: {
                        fontSize: '14px',
                                fontWeight:'bold'
                        }
                        },
                                plotLines: [{
                                value: 0,
                                        width: 1,
                                        color: '#808080'
                                }]
                        },
                        tooltip: {
                        formatter: function() {
                        return '<b>' + this.series.name + '</b><br/>' +
                                this.x + ': ' + this.y + '<?php echo $unita_misura; ?>';
                        }
                        },
                        legend: {
                        style: {
                        fontSize: '16px',
                                fontWeight:'bold'
                        },
                                y:20,
                                layout: 'vertical',
                                align: 'right',
                                verticalAlign: 'top',
                                borderWidth: 0,
                                floating:false
                        },
            <?php
            echo "series: [";

            for ($riga = 0; $riga < count($matrice_risultati); $riga++) {
                echo "{type: 'spline',name: '";
                echo $matrice_risultati[$riga][0] . "',
data: [";

                for ($colonna = 1; $colonna <= count($lista_nomi); $colonna++) {
                    echo $matrice_risultati[$riga][$colonna];
                    if ($colonna < count($lista_nomi))
                        echo ",";
                }
                echo "]}";
                if ($riga < count($matrice_risultati) - 1)
                    echo",";
            }
            echo" ]";
            ?>
                });
                });
            </script>
            <div class="col-md-<?php echo $size; ?> col-sm-<?php echo $size; ?> col-xs-<?php echo $size; ?>">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><?php echo $titolo; ?> <small><?php echo $sottotitolo; ?></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div id="container" style="height: 500px;width:100%; margin: 0 auto"></div>
                    </div>
                </div>
            </div><div class="row"></div>
            <?php
        }
    }

    function print2_graph($id, $matrice_risultati, $lista_nomi, $ordinata, $minimo, $unita_misura, $titolo, $sottotitolo, $size = "12") {
        ?>

        <script type="text/javascript">
            var chart_<?php echo $id; ?>;
            $(document).ready(function() {
            chart_<?php echo $id; ?> = new Highcharts.Chart({

            chart: {
            renderTo: 'container_chart_<?php echo $id; ?>',
                    marginTop: 50,
                    marginLeft: 80,
                    defaultSeriesType: 'line',
                    type: 'line',
                    zoomType: 'xy'
            },
                    credits: {
                    enabled: false
                    },
                    colors: ['#00B0F0', '#0066ff', '#7030A0', '#FF9900', '#33CC33', '#BF0000', '#003B89', '#7F7F7F', '#D9D9D9', '#a6c96a'],
                    title: {
                    text: ''
                    },
                    xAxis: [{
                    labels: {
                    style: {
                    fontSize: '14px',
                            fontWeight: 'bold'
                    }
                    },
        <?php
        echo "categories: [";
        $lista_nomi_visualizzati = _nome_mese($lista_nomi);
        if (count($lista_nomi_visualizzati) > 1) {
            foreach ($lista_nomi_visualizzati as $key => $value) {
                echo "'$value'";
                if ($key < count($lista_nomi_visualizzati) - 1)
                    echo ",";
            }
        } else
// print_r (_nome_mese($lista_nomi));
            echo "<th>$lista_nomi_visualizzati</th>";
        echo "]";
        ?>
                    }],
                    yAxis: {
                    marginTop: 10,
                            title: {
                            align: 'high',
                                    offset: - 60,
                                    rotation: 0,
                                    y: - 20,
                                    text: '<?php echo $ordinata; ?>'
                            }, <?php echo $minimo; ?>
                    labels: {
                    formatter: function() {
                    return this.value + '<?php echo $unita_misura; ?>';
                    }, style: {
                    fontSize: '14px',
                            fontWeight:'bold'
                    }
                    },
                            plotLines: [{
                            value: 0,
                                    width: 1,
                                    color: '#808080'
                            }]
                    },
                    tooltip: {
                    formatter: function() {
                    return '<b>' + this.series.name + '</b><br/>' +
                            this.x + ': ' + this.y + '<?php echo $unita_misura; ?>';
                    }
                    },
                    legend: {
                    style: {
                    fontSize: '16px',
                            fontWeight:'bold'
                    },
                            y:20,
                            layout: 'vertical',
                            align: 'right',
                            verticalAlign: 'top',
                            borderWidth: 0,
                            floating:false
                    },
        <?php
        echo "series: [";

        for ($riga = 0; $riga < count($matrice_risultati); $riga++) {
            echo "{type: 'spline',name: '";
            echo $matrice_risultati[$riga][0] . "',
data: [";

            for ($colonna = 1; $colonna <= count($lista_nomi); $colonna++) {
                echo $matrice_risultati[$riga][$colonna];
                if ($colonna < count($lista_nomi))
                    echo ",";
            }
            echo "]}";
            if ($riga < count($matrice_risultati) - 1)
                echo",";
        }
        echo" ]";
        ?>
            });
            });
        </script>

        <div class="col-md-<?php echo $size; ?> col-sm-<?php echo $size; ?> col-xs-<?php echo $size; ?>">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?php echo $titolo; ?> <small><?php echo $sottotitolo; ?></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div id="container_chart_<?php echo $id; ?>" style="height: 250px; width: auto; margin: 0 auto"></div>
                </div>
            </div>
        </div><div class="row"></div>
        <?php
    }

    function stampa_radar($lista_tabella, $tipo_terminale, $lista_condizioni, $piano, $fullroamers) {
        $risutlati_radar = 0;

        $table = $lista_tabella[count($lista_tabella) - 1];
        foreach ($lista_condizioni as $key => $value) {
            $risutlati_radar = drop_roaming($table, $value, $piano, $fullroamers);
            $lista_nomi[$key] = $risutlati_radar[0];
            $lista_valori1[$key] = $risutlati_radar[1];
            $lista_valori2[$key] = $risutlati_radar[2];
        }
        $media_nazionale = media_nazionale2($table, $tipo_terminale);
        //print_r($lista_nomi);
        //print_r($lista_valori1);
        //print_r($lista_valori2);
        $lista_nomi[count($lista_nomi)] = "National Average";
        $lista_valori1[count($lista_valori1)] = $media_nazionale[0];
        $lista_valori2[count($lista_valori2)] = $media_nazionale[1] / 100;
        radar($lista_valori1, $lista_valori2, $lista_nomi, "% roaming", "% drop", 1, 0.01, "%", "%", "Radar " . _nome_mese($table));
    }

    function print_graph_rbs($matrice, $ordinata = "", $minimo = "", $unita_misura = "", $titolo = "", $sottotitolo = "") {
        #$punti = count($matrice); 
        #$chiavi = array_keys($matrice[0]);
        $asse_x = array_column($matrice, 'time_end');
        
        $serie['RBs_PCELL'] = array_column(array_column($matrice, 'RBs'), 'PCELL');
        if (recursive_return_array_value_by_key('SCC1', $matrice)) {
            $serie['RBs_SCC1'] = array_column(array_column($matrice, 'RBs'), 'SCC1');     
        }
        if (recursive_return_array_value_by_key('SCC2', $matrice)) {
            $serie['RBs_SCC2'] = array_column(array_column($matrice, 'RBs'), 'SCC2');
        }
        
        $chiavi = array_keys($serie);        
        #print_r($chiavi);
        #print_r($serie); 
        ?>
        <script src="vendors/Highcharts-6.0.4/code/highcharts.js"></script>
        <script src="vendors/Highcharts-6.0.4/code/modules/series-label.js"></script>
        <script src="vendors/Highcharts-6.0.4/code/modules/exporting.js"></script>
        <script src="vendors/Highcharts-6.0.4/code/modules/boost.js"></script>
        <br>

        <div id="container_rbs"></div>


        <script type="text/javascript">
            Highcharts.chart('container_rbs', {

            chart: {
            zoomType: 'xy'
            },
                    /*
                     boost: {
                     useGPUTranslations: true
                     },
                     */

                    title: {
                    text: 'PRB'
                    },
                    subtitle: {
                    text: 'Qxdm (0xB173) LTE PDSCH'
                    },
                    /*  
                     xAxis: {
                     min: 0,
                     max: 120,
                     ordinal: false
                     },
                     units: [[
                     'millisecond', // unit name
                     [1, 2, 5, 10, 20, 25, 50, 100, 200, 500] // allowed multiples
                     ], [
                     'second',
                     [1, 2, 5, 10, 15, 30]
                     ],    
                     */

                    xAxis: [{

                    title: {
                    text: 'Second'
                    },
        <?php
        
        echo "categories: [";
        foreach ($asse_x as $key => $value) {
            $sec_val = round($value/1000,2);
            #$sec_val = $value;
            echo "'$sec_val'";
            if ($key < count($asse_x) - 1)
                echo ",";
        }
        echo "]";
        ?>
                    }],
                    yAxis: {
                    title: {
                    text: 'RBs number'
                    }
                    },
                    legend: {
                    layout: 'vertical',
                            align: 'right',
                            verticalAlign: 'middle'
                    },
                    tooltip: {
                    headerFormat: '<b>{series.name}</b><br>',
                            formatter: function() {
                            return 'time: ' + this.x + 'sec<br>n°: ' + this.y + '';
                            }

                    },
                    /*    
                     tooltip: {
                     formatter: function() {
                     return '<b>' + this.series.name + '</b><br/>' +
                     this.x + ': ' + this.y + '<?php echo $unita_misura; ?>';
                     }
                     },
                     */
                    plotOptions: {
                    spline: {
                    marker: {
                    enabled: true
                    }
                    }
                    },
        <?php
        echo "series: [";

        for ($riga = 0; $riga < count($chiavi); $riga++) {
            echo "{name: '";
            echo $chiavi[$riga] . "',
        data: [";

            for ($colonna = 0; $colonna < count($serie[$chiavi[$riga]]); $colonna++) {
                echo $serie[$chiavi[$riga]][$colonna];
                if ($colonna < count($serie[$chiavi[$riga]]))
                    echo ",";
            }
            echo "]}";
            if ($riga < count($serie[$chiavi[$riga]]) - 1)
                echo",";
        }
        echo" ],";
        ?>

            responsive: {
            rules: [{
            condition: {
            maxWidth: 500
            },
                    chartOptions: {
                    legend: {
                    layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                    }
                    }
            }]
            }

            });</script>
            <?php
        }

    
    function print_graph_layer($matrice, $ordinata = "", $minimo = "", $unita_misura = "", $titolo = "", $sottotitolo = "") {
        #$punti = count($matrice); 
        #$chiavi = array_keys($matrice[0]);
        $asse_x = array_column($matrice, 'time_end');
        
        $serie['Layer_PCELL'] = array_column(array_column($matrice, 'num_layer'), 'PCELL');
        
        if (recursive_return_array_value_by_key('SCC1', $matrice)) {
            $serie['Layer_SCC1'] = array_column(array_column($matrice, 'num_layer'), 'SCC1'); 
        }
     
        if (recursive_return_array_value_by_key('SCC2', $matrice)) {
            $serie['Layer_SCC2'] = array_column(array_column($matrice, 'num_layer'), 'SCC2');

        }
        
      
        $chiavi = array_keys($serie);
        
        #print_r($chiavi);
        #print_r($serie); 
        ?>
        <script src="vendors/Highcharts-6.0.4/code/highcharts.js"></script>
        <script src="vendors/Highcharts-6.0.4/code/modules/series-label.js"></script>
        <script src="vendors/Highcharts-6.0.4/code/modules/exporting.js"></script>
        <script src="vendors/Highcharts-6.0.4/code/modules/boost.js"></script>
        <br>

        <div id="container_layer"></div>


        <script type="text/javascript">
            Highcharts.chart('container_layer', {

            chart: {
            zoomType: 'xy'
            },
                    /*
                     boost: {
                     useGPUTranslations: true
                     },
                     */

                    title: {
                    text: 'LAYER'
                    },
                    subtitle: {
                    text: 'Qxdm (0xB173) LTE PDSCH'
                    },
                    /*  
                     xAxis: {
                     min: 0,
                     max: 120,
                     ordinal: false
                     },
                     units: [[
                     'millisecond', // unit name
                     [1, 2, 5, 10, 20, 25, 50, 100, 200, 500] // allowed multiples
                     ], [
                     'second',
                     [1, 2, 5, 10, 15, 30]
                     ],    
                     */

                    xAxis: [{

                    title: {
                    text: 'Second'
                    },
        <?php
        
        echo "categories: [";
        foreach ($asse_x as $key => $value) {
            $sec_val = round($value/1000,2);
            #$sec_val = $value;
            echo "'$sec_val'";
            if ($key < count($asse_x) - 1)
                echo ",";
        }
        echo "]";
        ?>
                    }],
                    yAxis: {
                    title: {
                    text: 'Layer number'
                    }
                    },
                    legend: {
                    layout: 'vertical',
                            align: 'right',
                            verticalAlign: 'middle'
                    },
                    tooltip: {
                    headerFormat: '<b>{series.name}</b><br>',
                            formatter: function() {
                            return 'time: ' + this.x + 'sec<br>layer n°: ' + this.y + '';
                            }

                    },
                    /*    
                     tooltip: {
                     formatter: function() {
                     return '<b>' + this.series.name + '</b><br/>' +
                     this.x + ': ' + this.y + '<?php echo $unita_misura; ?>';
                     }
                     },
                     */
                    plotOptions: {
                    spline: {
                    marker: {
                    enabled: true
                    }
                    }
                    },
        <?php
        echo "series: [";

        for ($riga = 0; $riga < count($chiavi); $riga++) {
            echo "{name: '";
            echo $chiavi[$riga] . "',
        data: [";

            for ($colonna = 0; $colonna < count($serie[$chiavi[$riga]]); $colonna++) {
                echo $serie[$chiavi[$riga]][$colonna];
                if ($colonna < count($serie[$chiavi[$riga]]))
                    echo ",";
            }
            echo "]}";
            if ($riga < count($serie[$chiavi[$riga]]) - 1)
                echo",";
        }
        echo" ],";
        ?>

            responsive: {
            rules: [{
            condition: {
            maxWidth: 500
            },
                    chartOptions: {
                    legend: {
                    layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                    }
                    }
            }]
            }

            });</script>
            <?php
        }
    
    function print_graph_schtime($matrice, $msec_scala, $ordinata = "", $minimo = "", $unita_misura = "", $titolo = "", $sottotitolo = "") {
        #$punti = count($matrice); 
        #$chiavi = array_keys($matrice[0]);
        $asse_x = array_column($matrice, 'time_end');
        
        $serie['TB_PCELL'] = array_column(array_column($matrice, 'TransportBlocks'), 'PCELL');
        if (recursive_return_array_value_by_key('SCC1', $matrice)) {
            $serie['TB_SCC1'] = array_column(array_column($matrice, 'TransportBlocks'), 'SCC1');     
        }
        if (recursive_return_array_value_by_key('SCC2', $matrice)) {
            $serie['TB_SCC2'] = array_column(array_column($matrice, 'TransportBlocks'), 'SCC2');

        }
        
      
        $chiavi = array_keys($serie);
        
        #print_r($chiavi);
        #print_r($serie); 
        ?>
        <script src="vendors/Highcharts-6.0.4/code/highcharts.js"></script>
        <script src="vendors/Highcharts-6.0.4/code/modules/series-label.js"></script>
        <script src="vendors/Highcharts-6.0.4/code/modules/exporting.js"></script>
        <script src="vendors/Highcharts-6.0.4/code/modules/boost.js"></script>

<br>
        <div id="container_schtime"></div>

        <script type="text/javascript">
            Highcharts.chart('container_schtime', {

            chart: {
            zoomType: 'xy'
            },
                    /*
                     boost: {
                     useGPUTranslations: true
                     },
                     */

                    title: {
                    text: 'Scheduling Time'
                    },
                    subtitle: {
                    text: 'Qxdm (0xB173) LTE PDSCH'
                    },
                    /*  
                     xAxis: {
                     min: 0,
                     max: 120,
                     ordinal: false
                     },
                     units: [[
                     'millisecond', // unit name
                     [1, 2, 5, 10, 20, 25, 50, 100, 200, 500] // allowed multiples
                     ], [
                     'second',
                     [1, 2, 5, 10, 15, 30]
                     ],    
                     */

                    xAxis: [{

                    title: {
                    text: 'Second'
                    },
        <?php
        
        echo "categories: [";
        foreach ($asse_x as $key => $value) {
            $sec_val = round($value/1000,2);
            #$sec_val = $value;
            echo "'$sec_val'";
            if ($key < count($asse_x) - 1)
                echo ",";
        }
        echo "]";
        ?>
                    }],
                    yAxis: {
                    title: {
                    text: 'Scheduling time (%)'
                    }
                    },
                    legend: {
                    layout: 'vertical',
                            align: 'right',
                            verticalAlign: 'middle'
                    },
                    tooltip: {
                    headerFormat: '<b>{series.name}</b><br>',
                            formatter: function() {
                            return 'time: ' + this.x + 'sec<br>scheduling time: ' + this.y + '%';
                            }

                    },
                    /*    
                     tooltip: {
                     formatter: function() {
                     return '<b>' + this.series.name + '</b><br/>' +
                     this.x + ': ' + this.y + '<?php echo $unita_misura; ?>';
                     }
                     },
                     */
                    plotOptions: {
                    spline: {
                    marker: {
                    enabled: true
                    }
                    }
                    },
        <?php
        echo "series: [";

        for ($riga = 0; $riga < count($chiavi); $riga++) {
            echo "{name: '";
            echo $chiavi[$riga] . "',
        data: [";

            for ($colonna = 0; $colonna < count($serie[$chiavi[$riga]]); $colonna++) {
                $percent_val = round($serie[$chiavi[$riga]][$colonna]/$msec_scala*100,2);
                #echo $serie[$chiavi[$riga]][$colonna];
                echo $percent_val;
                if ($colonna < count($serie[$chiavi[$riga]]))
                    echo ",";
            }
            echo "]}";
            if ($riga < count($serie[$chiavi[$riga]]) - 1)
                echo",";
        }
        echo" ],";
        ?>

            responsive: {
            rules: [{
            condition: {
            maxWidth: 500
            },
                    chartOptions: {
                    legend: {
                    layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                    }
                    }
            }]
            }

            });</script>
            <?php
        }
    
    function print_graph_modulation($matrice, $ordinata = "", $minimo = "", $unita_misura = "", $titolo = "", $sottotitolo = "") {
        #$punti = count($matrice); 
        #$chiavi = array_keys($matrice[0]);
        $asse_x = array_column($matrice, 'time_end');
        
        $serie['TB0_PCELL'] = array_column(array_column($matrice, 'TB0'), 'PCELL');          
        $serie['TB1_PCELL'] = array_column(array_column($matrice, 'TB1'), 'PCELL');
        
        if (recursive_return_array_value_by_key('SCC1', $matrice)) {
            $serie['TB0_SCC1'] = array_column(array_column($matrice, 'TB0'), 'SCC1');
            $serie['TB1_SCC1'] = array_column(array_column($matrice, 'TB1'), 'SCC1'); 

        }
        
        if (recursive_return_array_value_by_key('SCC2', $matrice)) {
            $serie['TB0_SCC2'] = array_column(array_column($matrice, 'TB0'), 'SCC2');
            $serie['TB1_SCC2'] = array_column(array_column($matrice, 'TB1'), 'SCC2');  
        }

        
      
        $chiavi = array_keys($serie);
        
        #print_r($chiavi);
        #print_r($serie); 
        ?>
        <script src="vendors/Highcharts-6.0.4/code/highcharts.js"></script>
        <script src="vendors/Highcharts-6.0.4/code/modules/series-label.js"></script>
        <script src="vendors/Highcharts-6.0.4/code/modules/exporting.js"></script>
        <script src="vendors/Highcharts-6.0.4/code/modules/boost.js"></script>
<br>

        <div id="container_modulation"></div>

        <script type="text/javascript">
            Highcharts.chart('container_modulation', {

            chart: {
            zoomType: 'xy'
            },
                    /*
                     boost: {
                     useGPUTranslations: true
                     },
                     */

                    title: {
                    text: 'Modulation Type'
                    },
                    subtitle: {
                    text: 'Qxdm (0xB173) LTE PDSCH'
                    },
                    /*  
                     xAxis: {
                     min: 0,
                     max: 120,
                     ordinal: false
                     },
                     units: [[
                     'millisecond', // unit name
                     [1, 2, 5, 10, 20, 25, 50, 100, 200, 500] // allowed multiples
                     ], [
                     'second',
                     [1, 2, 5, 10, 15, 30]
                     ],    
                     */

                    xAxis: [{

                    title: {
                    text: 'Second'
                    },
        <?php
        
        echo "categories: [";
        foreach ($asse_x as $key => $value) {
            $sec_val = round($value/1000,2);
            #$sec_val = $value;
            echo "'$sec_val'";
            if ($key < count($asse_x) - 1)
                echo ",";
        }
        echo "]";
        ?>
                    }],
                    yAxis: {
                    title: {
                    text: 'Modulation Type'
                    }
                    },
                    legend: {
                    layout: 'vertical',
                            align: 'right',
                            verticalAlign: 'middle'
                    },
                    tooltip: {
                    headerFormat: '<b>{series.name}</b><br>',
                            formatter: function() {
                            return 'time: ' + this.x + 'sec<br>Mod. type: ' + this.y + '<br>--Legend--<br>4= 256QAM<br>3= 64QAM<br>2= 16QAM<br>1= QPSK';
                            }

                    },
                    /*    
                     tooltip: {
                     formatter: function() {
                     return '<b>' + this.series.name + '</b><br/>' +
                     this.x + ': ' + this.y + '<?php echo $unita_misura; ?>';
                     }
                     },
                     */
                    plotOptions: {
                    spline: {
                    marker: {
                    enabled: true
                    }
                    }
                    },
        <?php
        echo "series: [";

        for ($riga = 0; $riga < count($chiavi); $riga++) {
            echo "{name: '";
            echo $chiavi[$riga] . "',
        data: [";

            for ($colonna = 0; $colonna < count($serie[$chiavi[$riga]]); $colonna++) {
                echo $serie[$chiavi[$riga]][$colonna];
                if ($colonna < count($serie[$chiavi[$riga]]))
                    echo ",";
            }
            echo "]}";
            if ($riga < count($serie[$chiavi[$riga]]) - 1)
                echo",";
        }
        echo" ],";
        ?>

            responsive: {
            rules: [{
            condition: {
            maxWidth: 500
            },
                    chartOptions: {
                    legend: {
                    layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                    }
                    }
            }]
            }

            });</script>
            <?php
        }
    
    function assiY($matrice, $parametro){

        $serie[$parametro.'_PCELL'] = array_column(array_column($matrice, $parametro), 'PCell');
        if (recursive_return_array_value_by_key('SCC1', $matrice)) {
            $serie[$parametro.'_SCC1'] = array_column(array_column($matrice, $parametro), 'SCC1');     
        }
        if (recursive_return_array_value_by_key('SCC2', $matrice)) {
            $serie[$parametro.'_SCC2'] = array_column(array_column($matrice, $parametro), 'SCC2');

        }         
        return $serie;
    }
      

    function num2dbm($n){
        if(is_numeric($n)){
            $var = floatval($n);
            return 10*log10($var);
        }
        else { 
            return 0; 
            
        }
    }   
        

    function print_graph_parametro($matrice, $serie, $unita_misura = "", $titolo = "", $sottotitolo = "") {

        $asse_x = array_column($matrice, 'time_end'); 
        $chiavi = array_keys($serie);

        #echo'<pre>';
        #print_r($chiavi);
        #print_r($serie);
        #echo'</pre>';
        ?>
        <script src="vendors/Highcharts-6.0.4/code/highcharts.js"></script>
        <script src="vendors/Highcharts-6.0.4/code/modules/series-label.js"></script>
        <script src="vendors/Highcharts-6.0.4/code/modules/exporting.js"></script>
        <script src="vendors/Highcharts-6.0.4/code/modules/boost.js"></script>
        <br>

        <div id="container_<?php echo $titolo; ?>"></div>


        <script type="text/javascript">
            Highcharts.chart('container_<?php echo $titolo; ?>', {

            chart: {
            zoomType: 'xy'
            },
                    /*
                     boost: {
                     useGPUTranslations: true
                     },
                     */

                    title: {
                    text: '<?php echo $titolo;?>'
                    
                    },
                    subtitle: {
                    text: '<?php echo $sottotitolo;?>'
                    },
                    /*  
                     xAxis: {
                     min: 0,
                     max: 120,
                     ordinal: false
                     },
                     units: [[
                     'millisecond', // unit name
                     [1, 2, 5, 10, 20, 25, 50, 100, 200, 500] // allowed multiples
                     ], [
                     'second',
                     [1, 2, 5, 10, 15, 30]
                     ],    
                     */

                    xAxis: [{

                    title: {
                    text: 'Second'
                    },
        <?php
        
        echo "categories: [";
        foreach ($asse_x as $key => $value) {
            $sec_val = round($value/1000,2);
            #$sec_val = $value;
            echo "'$sec_val'";
            if ($key < count($asse_x) - 1)
                echo ",";
        }
        echo "]";
        ?>
                    }],
                    yAxis: {
                    title: {
                    text: '<?php echo $unita_misura; ?>'
                    }
                    },
                    legend: {
                    layout: 'vertical',
                            align: 'right',
                            verticalAlign: 'middle'
                    },
                    tooltip: {
                    headerFormat: '<b>{series.name}</b><br>',
                            formatter: function() {
                            return 'time: ' + this.x + 'sec<br><?php echo $unita_misura; ?>: ' + this.y + '';
                            }

                    },
                    /*    
                     tooltip: {
                     formatter: function() {
                     return '<b>' + this.series.name + '</b><br/>' +
                     this.x + ': ' + this.y + '<?php echo $unita_misura; ?>';
                     }
                     },
                     */
                    plotOptions: {
                    spline: {
                    marker: {
                    enabled: true
                    }
                    }
                    },
        <?php
        echo "series: [";

        for ($riga = 0; $riga < count($chiavi); $riga++) {
            echo "{name: '";
            echo $chiavi[$riga] . "',
        data: [";

            for ($colonna = 0; $colonna < count($serie[$chiavi[$riga]]); $colonna++) {
                echo $serie[$chiavi[$riga]][$colonna];
                if ($colonna < count($serie[$chiavi[$riga]]))
                    echo ",";
            }
            echo "]}";
            if ($riga < count($serie[$chiavi[$riga]]) - 1)
                echo",";
        }
        echo" ],";
        ?>

            responsive: {
            rules: [{
            condition: {
            maxWidth: 500
            },
                    chartOptions: {
                    legend: {
                    layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                    }
                    }
            }]
            }

            });</script>
            <?php
        }    
        
    function print_graph_parametrox4($asse_x, $parametro, $unita_misura = "", $titolo = "", $sottotitolo = "") {
        
        foreach ($parametro as $sub) {
            foreach ($sub as $key => $value) {
              $serie[$key] = $value;  
            }
            
        }

        $chiavi = array_keys($serie);

        #echo'<pre>';
        #print_r($chiavi);
        #print_r($serie);
        #echo'</pre>';
        ?>
        <script src="vendors/Highcharts-6.0.4/code/highcharts.js"></script>
        <script src="vendors/Highcharts-6.0.4/code/modules/series-label.js"></script>
        <script src="vendors/Highcharts-6.0.4/code/modules/exporting.js"></script>
        <script src="vendors/Highcharts-6.0.4/code/modules/boost.js"></script>
        <br>

        <div id="container_<?php echo $titolo; ?>"></div>


        <script type="text/javascript">
            Highcharts.chart('container_<?php echo $titolo; ?>', {

            chart: {
            zoomType: 'xy'
            },
                    /*
                     boost: {
                     useGPUTranslations: true
                     },
                     */

                    title: {
                    text: '<?php echo $titolo;?>'
                    
                    },
                    subtitle: {
                    text: '<?php echo $sottotitolo;?>'
                    },
                    /*  
                     xAxis: {
                     min: 0,
                     max: 120,
                     ordinal: false
                     },
                     units: [[
                     'millisecond', // unit name
                     [1, 2, 5, 10, 20, 25, 50, 100, 200, 500] // allowed multiples
                     ], [
                     'second',
                     [1, 2, 5, 10, 15, 30]
                     ],    
                     */

                    xAxis: [{

                    title: {
                    text: 'Second'
                    },
        <?php
        
        echo "categories: [";
        foreach ($asse_x as $key => $value) {
            $sec_val = round($value/1000,2);
            #$sec_val = $value;
            echo "'$sec_val'";
            if ($key < count($asse_x) - 1)
                echo ",";
        }
        echo "]";
        ?>
                    }],
                    yAxis: {
                    title: {
                    text: '<?php echo $unita_misura; ?>'
                    }
                    },
                    legend: {
                    layout: 'vertical',
                            align: 'right',
                            verticalAlign: 'middle'
                    },
                    tooltip: {
                    headerFormat: '<b>{series.name}</b><br>',
                            formatter: function() {
                            return 'time: ' + this.x + 'sec<br><?php echo $unita_misura; ?>: ' + this.y + '';
                            }

                    },
                    /*    
                     tooltip: {
                     formatter: function() {
                     return '<b>' + this.series.name + '</b><br/>' +
                     this.x + ': ' + this.y + '<?php echo $unita_misura; ?>';
                     }
                     },
                     */
                    plotOptions: {
                    spline: {
                    marker: {
                    enabled: true
                    }
                    }
                    },
        <?php
        echo "series: [";

        for ($riga = 0; $riga < count($chiavi); $riga++) {
            echo "{name: '";
            echo $chiavi[$riga] . "',
        data: [";

            for ($colonna = 0; $colonna < count($serie[$chiavi[$riga]]); $colonna++) {
                echo $serie[$chiavi[$riga]][$colonna];
                if ($colonna < count($serie[$chiavi[$riga]]))
                    echo ",";
            }
            echo "]}";
            if ($riga < count($serie[$chiavi[$riga]]) - 1)
                echo",";
        }
        echo" ],";
        ?>

            responsive: {
            rules: [{
            condition: {
            maxWidth: 500
            },
                    chartOptions: {
                    legend: {
                    layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                    }
                    }
            }]
            }

            });</script>
            <?php
        }    
        

         
}
