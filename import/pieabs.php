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
  
  //take the values from arrayNum1
  var orderedValues = <?php echo json_encode($arrayNum1); ?>;

	//Set the canvas
    var canvasWidth = 300, //width
      canvasHeight = 300,   //height
      outerRadius = 100,   //radius
      color = d3.scale.category20(); //builtin range of colors
 
    var dataSet = [
      {sentiment:"Negative", nnumb:22}, 
      {sentiment:"Neutral", nnumb:40}, 
      {sentiment:"Positive", nnumb:50}];
      
    //this function assign my values to dataSet
  	function changeCount( sentiment, nnumb ) {
 		for (var i in dataSet) {
    		//when santiment corrispond, assign new value
    		if (dataSet[i].sentiment == sentiment) {
        		dataSet[i].nnumb = nnumb;
        		break; 
    		 }
   		}
  	}
  
  //call funcion
  var neg = parseInt(orderedValues[0]);
  changeCount ( 'Negative', neg );
  var neu = parseInt(orderedValues[1]);
  changeCount ( 'Neutral', neu );
  var pos = parseInt(orderedValues[2]);
  changeCount ( 'Positive', pos );
 
 
    var totalCount = d3.sum(dataSet, function(d) { return d.nnumb;}),
        toPercent = d3.format("0.1%");
       
    
    var vis = d3.select(".pie-result-title")
      .append("svg:svg") 
        .data([dataSet]) 
        .attr("width", canvasWidth) 
        .attr("height", canvasHeight) 
        .append("svg:g") 
          .attr("transform", "translate(" + 1.5*outerRadius + "," + 1.5*outerRadius + ")") // relocate center of pie to 'outerRadius,outerRadius'

 
    var arc = d3.svg.arc()
      .outerRadius(outerRadius);
 
    var pie = d3.layout.pie() 
      .value(function(d) { return d.nnumb; }) 
      .sort( function(d) { return null; } );
 
    var arcs = vis.selectAll("g.slice")
      .data(pie)
      .enter()
      .append("svg:g")
      .attr("class", "slice");   
 
    arcs.append("svg:path")
      .attr("fill", function(d, i) { return color(i); } )
      .attr("d", arc);
 
    arcs.append("svg:text")
      .attr("transform", function(d) { 
        d.outerRadius = outerRadius + 50; 
        d.innerRadius = outerRadius + 45; 
        return "translate(" + arc.centroid(d) + ")";
      })
      .attr("text-anchor", "middle") 
      .style("fill", "Purple")
      .style("font", "bold 12px Arial")
      .text(function(d, i) { return dataSet[i].sentiment; }); 
 
   arcs.filter(function(d) { return d.endAngle - d.startAngle > .2; }).append("svg:text")
    .attr("dy", ".35em")
    .attr("text-anchor", "middle")
    .attr("transform", function(d) { 
        d.outerRadius = outerRadius; 
        d.innerRadius = outerRadius/2; 
        return "translate(" + arc.centroid(d) + ")rotate(" + angle(d) + ")";
      })
      .style("fill", "White")
      .style("font", "bold 12px Arial")
     .text(function(d) { return d.data.nnumb; });

    function angle(d) {
      var a = (d.startAngle + d.endAngle) * 90 / Math.PI - 90;
      return a > 90 ? a - 180 : a;
    }       
    </script>
  </body>
</html>