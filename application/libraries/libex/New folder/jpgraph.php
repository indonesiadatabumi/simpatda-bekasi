<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * add librarie jpgraph into codeigniter
 * @author Daniel Hutauruk
 */
class Jpgraph {
	/**
	 * line chart
	 */
	public function linechart($datay, $title='Line Chart', $width = 350, $height = 250, $timeout = 60) {
		require_once 'jpgraph/jpgraph.php';
		require_once 'jpgraph/jpgraph_line.php';
		
		 // Create the graph. These two calls are always required
        $graph = new Graph($width, $height,"auto", $timeout);
        $graph->img->SetMargin(60,20,35,75);
        $graph->SetScale("textlin");
		$graph->SetShadow();
        
        // Setup title
        $graph->title->Set($title);
        
        // Create the linear plot
        $lineplot=new LinePlot($datay);
        $lineplot->SetColor("blue");
        
        // Add the plot to the graph
        $graph->Add($lineplot);
        
        return $graph;
	}
	
	/**
	 * bar chart
	 */
	public function barchart($datax, $datay, $title = 'Bar Chart', $titlex = '', $titley = '', $width = 350, $height = 250) {
		require_once 'jpgraph/jpgraph.php';
		require_once 'jpgraph/jpgraph_bar.php';
		
		// Setup the graph.
		$graph = new Graph($width, $height);
		$graph->SetScale('textlin');
		// Add a drop shadow
		$graph->SetShadow();		
		// Adjust the margin a bit to make more room for titles
		$graph->img->SetMargin(60,20,35,75);
		
		// Create a bar pot
		$bplot = new BarPlot($datay);
		$graph->Add($bplot);
       
		// Set up the title for the graph
		$graph->title->Set($title);
		$graph->xaxis->title->Set($titlex);
		$graph->yaxis->title->Set($titley);
		
		$graph->title->SetFont(FF_FONT1,FS_BOLD);
		$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
		$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
		
		// Show 0 label on Y-axis (default is not to show)
		$graph->yscale->ticks->SupressZeroLabel(true);
		
		// Setup X-axis labels
		$graph->xaxis->SetTickLabels($datax);
        
        return $graph;
	}
}
