<!DOCTYPE html>
<html>
  <head>    
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <title>pie </title>
 
    <script type="text/javascript" src="d3/d3.js"></script>
 
    <style type="text/css">
        .slice text {
            font-size: 16pt;
            font-family: Arial;
        }   
    </style>
    
  </head>
  <body>
    <script type="text/javascript">
  
  //import my array
  var orderedValues = <?php echo json_encode($arrayNum); ?>;

	//canvas and color
    var canvasWidth = 300, 
      canvasHeight = 300,   
      outerRadius = 100,   
      color = d3.scale.category20(); 
 
    var dataSet = [
      {sentiment:"Negative", nnumb:22}, 
      {sentiment:"Neutral", nnumb:40}, 
      {sentiment:"Positive", nnumb:50}];
    
     
   //function to assign my values to dataSet     
  function changeCount( sentiment, nnumb ) {
	 for (var i in dataSet) {
    	 if (dataSet[i].sentiment == sentiment) {
        	dataSet[i].nnumb = nnumb;
        	break; 
     	}
   	 }
  }
  
  	var neg = parseInt(orderedValues[0]);
  	changeCount ( 'Negative', neg );
  	var neu = parseInt(orderedValues[1]);
  	changeCount ( 'Neutral', neu );
  	var pos = parseInt(orderedValues[2]);
  	changeCount ( 'Positive', pos );
 
    var totalCount = d3.sum(dataSet, function(d) { return d.nnumb;}),
        toPercent = d3.format("0.1%");
    
    
    //select the title of the div to append the chart
    var vis = d3.select(".pie-result-title")
      .append("svg:svg") //create the SVG element 
        .data([dataSet]) //associate dataSet 
        .attr("width", canvasWidth) //set the canvas
        .attr("height", canvasHeight) //set the canvas
        .append("svg:g") //make a group
          .attr("transform", "translate(" + 1.5*outerRadius + "," + 1.5*outerRadius + ")") // relocate center of pie to 'outerRadius,outerRadius'

 
    // This will create <path> elements 
    var arc = d3.svg.arc()
      .outerRadius(outerRadius);
 
    var pie = d3.layout.pie() //this will create arc data
      .value(function(d) { return d.nnumb; }) // Associate each value to the pie
      .sort( function(d) { return null; } );
 
    // Select all <g> elements with class slice (there aren't any yet)
    var arcs = vis.selectAll("g.slice")
      .data(pie)
      .enter()
      // Create a group to hold each slice (with <path> and a <text>
      // element associated with each)
      .append("svg:g")
      .attr("class", "slice");   
 
 
	 //set colors and svg
    	arcs.append("svg:path")
      	.attr("fill", function(d, i) { return color(i); } )
      	//this creates the actual SVG path using the associated data (pie) with the arc drawing function
      	.attr("d", arc);
 
    	// Add a sentiment to each arc
    	arcs.append("svg:text")
      	.attr("transform", function(d) { //set the label's origin to the center of the arc
        d.outerRadius = outerRadius + 50; // Set Outer Coordinate
        d.innerRadius = outerRadius + 45; // Set Inner Coordinate
        return "translate(" + arc.centroid(d) + ")";
      })
      	.attr("text-anchor", "middle") //center the text on it's origin
      	.style("fill", "Purple")
      	.style("font", "bold 12px Arial")
      	.text(function(d, i) { return dataSet[i].sentiment; }); 
 
    // Add a nnumb value to the larger arcs, translated to the arc centroid and rotated.
  	 arcs.filter(function(d) { return d.endAngle - d.startAngle > .2; }).append("svg:text")
    	.attr("dy", ".35em")
    	.attr("text-anchor", "middle")
      	.attr("transform", function(d) { //set the label's origin to the center of the arc
        d.outerRadius = outerRadius; // Set Outer Coordinate
        d.innerRadius = outerRadius/2; // Set Inner Coordinate
        return "translate(" + arc.centroid(d) + ")rotate(" + angle(d) + ")";
      })
   	   	.style("fill", "White")
    	.style("font", "bold 12px Arial")
	    .text(function(d) { return d.data.nnumb + "(" + toPercent(d.data.nnumb / totalCount) + ")" ; });
 
 	   // Computes the angle of an arc, converting from radians to degrees.
    	function angle(d) {
      		var a = (d.startAngle + d.endAngle) * 90 / Math.PI - 90;
      		return a > 90 ? a - 180 : a;
    	}  
    </script>
  </body>
</html>