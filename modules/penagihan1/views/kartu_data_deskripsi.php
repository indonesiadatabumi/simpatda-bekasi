

<script type="text/javascript" src="<?=base_url();?>/assets/scripts/jquery/jquery.jqplot.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>/assets/scripts/jquery/plugins/jqplot.json2.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>/assets/scripts/jquery/plugins/jqplot.barRenderer.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>/assets/scripts/jquery/plugins/jqplot.pointLabels.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>/assets/scripts/jquery/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<link rel="stylesheet" type="text/css" hrf="<?= base_url();?>/assets/styles/jquery/jquery.jqplot.min.css" />


<div id="chart1" style="width:800px; height:350px;" /></div>

<script>
$(document).ready(function(){
	try {
		$(document).ready(function(){
	        var ajaxDataRenderer = function(url, plot, options) {
	            var ret = null;
	            $.ajax({
	              // have to use synchronous here, else the function
	              // will return before the data is fetched
	              async: false,
	              url: url,
	              dataType:"json",
	              success: function(data) {
	                ret = data;
	              }
	            });
	            return ret;
	          };
	          
	        var jsonurl = "<?= base_url();?>penagihan/kartu_data_wp/get_data";
	        var ticks = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agus', 'Sep', 'Okt', 'Nov', 'Des'];
	         
	        plot1 = $.jqplot('chart1', jsonurl, {
	            // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
	            // Turns on animatino for all series in this plot.
		        animate: true,
		        // Will animate plot on calls to plot1.replot({resetAxes:true})
		        animateReplot: true,
	            seriesDefaults:{
	                renderer:$.jqplot.BarRenderer,
	                pointLabels: { show: true },
	             	// Speed up the animation a little bit.
                    // This is a number of milliseconds. 
                    // Default for bar series is 3000. 
                    animation: {
                        speed: 500
                    }
	            },
	            axes: {
	                xaxis: {
	                    renderer: $.jqplot.CategoryAxisRenderer,
	                    ticks: ticks
	                }
	            },
	            highlighter: { show: false },
	            dataRenderer: ajaxDataRenderer,
	            dataRendererOptions: {
	              unusedOptionalUrl: jsonurl
	            }
	        });
	     
	        $('#chart1').bind('jqplotDataClick',
	            function (ev, seriesIndex, pointIndex, data) {
	                $('#info1').html('series: '+seriesIndex+', point: '+pointIndex+', data: '+data);
	            }
	        );
	    });
		
	} catch (e) {
		
	}	 
});

</script>