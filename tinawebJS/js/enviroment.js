

//============================ < NEW BUTTONS > =============================//

//obsolete
function changeButton(bc) { 
    if(!isUndef(bc.id) && bc.id!=swclickActual) {
        
        if(bc.id!="switch") pushSWClick(bc.id);
        else pushSWClick(swclickActual)
        
        pr("\t***changebutton bc.id:"+bc.id+" , swMacro:"+swMacro)
        if(bc.id=="social") {
            if(swMacro) changeToMacro(bc.id);
            else changeToMeso(bc.id);
            //			$("#category-A").show();
            //			$("#category-B").hide();
        }
        if(bc.id=="semantic") {
            if(swMacro) changeToMacro(bc.id);
            else changeToMeso(bc.id);
            //			$("#category-A").hide();
            //			$("#category-B").show();
        }
        if(bc.id=="sociosemantic") {
            if(swMacro) changeToMacro(bc.id);
            else changeToMeso(bc.id);
            //			$("#category-A").show();
            //			$("#category-B").show();
        }
        if(bc.id=="switch"){
            if(swMacro) changeToMacro(swclickActual);
            else changeToMeso(swclickActual);
        }
    }

    //    fullurl = returnBaseUrl()+"img/trans/";
    //    if(img.id=="socio") {
    //        if ( img.src==fullurl+"hover_scholars.png" ) {
    //            changeButton("active_scholars.png");
    //            if(document.getElementById("viewType").src==fullurl+"status_macro_view.png"){
    //                changeToMacro("social");
    //            }
    //            if(document.getElementById("viewType").src==fullurl+"status_meso_view.png"){
    //                changeToMeso("social");
    //            }
    //        }
    //    }
    //    
    //    if(img.id=="semantic") { 
    //        if ( img.src==fullurl+"hover_tags.png" ) { 
    //            changeButton("active_tags.png");
    //            if(document.getElementById("viewType").src==fullurl+"status_macro_view.png"){
    //                changeToMacro("semantic");
    //            }
    //            if(document.getElementById("viewType").src==fullurl+"status_meso_view.png"){
    //                changeToMeso("semantic");
    //            }
    //        }
    //    }
    //    
    //    if(img.id=="sociosemantic") { 
    //        if ( img.src==fullurl+"hover_sociosem.png" ) { 
    //            changeButton("active_sociosem.png");
    //            if(document.getElementById("viewType").src==fullurl+"status_macro_view.png"){
    //                changeToMacro("sociosemantic");
    //            }
    //            if(document.getElementById("viewType").src==fullurl+"status_meso_view.png"){
    //                changeToMeso("sociosemantic");
    //            }
    //        }
    //        
    //    }
    //    if(img.id=="switch") { 
    //        hasbeenclicked=false;
    //        if ( img.src==fullurl+"graph_meso.png"){
    //            changeButton("graph_macro.png");   
    //            pushSWClick(swclickActual);
    //            changeToMeso(swclickActual);
    //            hasbeenclicked=true;       
    //        }
    //        if ( img.src==fullurl+"graph_macro.png" && hasbeenclicked==false){
    //            changeButton("graph_meso.png");    
    //            pushSWClick(swclickActual);
    //            changeToMacro(swclickActual);
    //        }
    //    }





    //    fullurl = returnBaseUrl()+"img/trans/";
    //    hasbeenclicked=false;
    //    if(bc=="graph_meso.png"){
    //        document.getElementById("switch").src=fullurl+"graph_meso.png";
    //        document.getElementById("viewType").src=fullurl+"status_macro_view.png";
    //        hasbeenclicked=true;
    //    }
    //    if(bc=="graph_macro.png" && hasbeenclicked==false){
    //        document.getElementById("switch").src=fullurl+"graph_macro.png";
    //        document.getElementById("viewType").src=fullurl+"status_meso_view.png";
    //    }
    //    
    //    if(bc=="active_scholars.png"){
    //        document.getElementById("socio").src=fullurl+"active_scholars.png";
    //        document.getElementById("semantic").src=fullurl+"inactive_tags.png";
    //        document.getElementById("sociosemantic").src=fullurl+"inactive_sociosem.png";
    //        pushSWClick("social"); 
    //        pr("swclickPrev: "+swclickPrev+" - swclickActual: "+swclickActual);
    //        $("#category-A").show();
    //        $("#category-B").hide();
    //    }  
    //    if(bc=="active_tags.png"){
    //        document.getElementById("socio").src=fullurl+"inactive_scholars.png";
    //        document.getElementById("semantic").src=fullurl+"active_tags.png";
    //        document.getElementById("sociosemantic").src=fullurl+"inactive_sociosem.png";
    //        pushSWClick("semantic"); 
    //        pr("swclickPrev: "+swclickPrev+" - swclickActual: "+swclickActual);     
    //        $("#category-A").hide();
    //        $("#category-B").show();
    //    }
    //    if(bc=="active_sociosem.png"){
    //        document.getElementById("socio").src=fullurl+"inactive_scholars.png";
    //        document.getElementById("semantic").src=fullurl+"inactive_tags.png";
    //        document.getElementById("sociosemantic").src=fullurl+"active_sociosem.png";
    //        pushSWClick("sociosemantic");
    //        pr("swclickPrev: "+swclickPrev+" - swclickActual: "+swclickActual);
    //        $("#category-A").show();
    //        $("#category-B").show();
    //    }
    //    if(bc=="selectNode"){        
    //        if(categories.length==2) $("#switchbutton").show();
    //        if(document.getElementById("switch").src==fullurl+"graph_meso_null.png"){
    //            if(document.getElementById("viewType").src==fullurl+"status_macro_view.png"){
    //                document.getElementById("switch").src=fullurl+"graph_meso.png";
    //            }
    //            if(document.getElementById("viewType").src==fullurl+"status_meso_view.png"){
    //                document.getElementById("switch").src=fullurl+"graph_macro.png";
    //            }
    //        }
    //    }
    //    if(bc=="unselectNodes"){
    //        document.getElementById("switch").src=fullurl+"graph_meso_null.png";
    //    }
    //    /*tofix*/
    ////    if(is_empty(selections)){        
    ////        /***** The animation *****/
    ////        _cG = $("#leftcolumn");    
    ////        _cG.animate({
    ////            "left" : "-" + _cG.width() + "px"
    ////        }, function() {
    ////            $("#aUnfold").attr("class","rightarrow");
    ////            $("#zonecentre").css({
    ////                left: "0"
    ////            });
    ////        });
    ////    }
}

function changeType() {
    pr("***swclickActual:"+swclickActual+" , swMacro:"+swMacro)
    if(swclickActual=="social") {
        if(swMacro) {
        	changeToMacro("semantic");
	        pushSWClick("semantic");
	        RefreshState("B")
        } else {
        	changeToMeso("sociosemantic");
	        pushSWClick("sociosemantic");
        	RefreshState("AaBb")
        }
        return;
    }
    if(swclickActual=="semantic") {
        if(swMacro) {
        	changeToMacro("social");
	        pushSWClick("social");
	        RefreshState("A")
        } else {
        	changeToMeso("sociosemantic");
	        pushSWClick("sociosemantic");
        	RefreshState("AaBb")
        }
        return;
    }
    if(swclickActual=="sociosemantic") {
    	
    	if(swMacro) {
    		changeToMacro("sociosemantic");
	        pushSWClick("sociosemantic");
	        RefreshState("AaBb")
    	} else {
	        pushSWClick(swclickPrev);
        	changeToMeso(swclickActual);
        	RefreshState(PAST)
    	}
        // if(swMacro) {
        // 	changeToMacro("semantic");
	       //  pushSWClick("semantic");
	       //  RefreshState("B")
	       //  $("#category-A").hide();
	       //  $("#category-B").show();
        // } else {
        // 	changeToMeso("sociosemantic");
	       //  pushSWClick("sociosemantic");
        // 	RefreshState("AaBb")
	       //  $("#category-A").show();
	       //  $("#category-B").show();
        // }
        return;
    }
}

function changeLevel() {
    bf=swclickActual
    pushSWClick(swclickActual);
    pr("swMacro: "+swMacro+" - [swclickPrev: "+bf+"] - [swclickActual: "+swclickActual+"]")

    if(swMacro){
	    if(swclickActual=="social") {
	    	changeToMeso("social")
	    	RefreshState("a");
	    }
	    if(swclickActual=="semantic") {
	    	changeToMeso("semantic")
	    	RefreshState("b");
	    }
	    swMacro=false;
	} else {
	    if(swclickActual=="social") {
	    	changeToMacro("social")
	    	RefreshState("A")
	    }
	    if(swclickActual=="semantic") {
	    	changeToMacro("semantic")
	    	RefreshState("B")
	    }
	    swMacro=true;
	}
    // changeToMeso("social")
    // changeToMeso("semantic")

    // changeToMacro("social")
    // changeToMacro("semantic")
}

//obsolete
function changeHoverActive(img) {
    fullurl = returnBaseUrl()+"img/trans/";
    if(img.id=="socio") {
        if ( img.src==fullurl+"hover_scholars.png" ) {
            changeButton("active_scholars.png");
            if(document.getElementById("viewType").src==fullurl+"status_macro_view.png"){
                changeToMacro("social");
            }
            if(document.getElementById("viewType").src==fullurl+"status_meso_view.png"){
                changeToMeso("social");
            }
        }
    }
    
    if(img.id=="semantic") { 
        if ( img.src==fullurl+"hover_tags.png" ) { 
            changeButton("active_tags.png");
            if(document.getElementById("viewType").src==fullurl+"status_macro_view.png"){
                changeToMacro("semantic");
            }
            if(document.getElementById("viewType").src==fullurl+"status_meso_view.png"){
                changeToMeso("semantic");
            }
        }
    }
    
    if(img.id=="sociosemantic") { 
        if ( img.src==fullurl+"hover_sociosem.png" ) { 
            changeButton("active_sociosem.png");
            if(document.getElementById("viewType").src==fullurl+"status_macro_view.png"){
                changeToMacro("sociosemantic");
            }
            if(document.getElementById("viewType").src==fullurl+"status_meso_view.png"){
                changeToMeso("sociosemantic");
            }
        }
        
    }
    if(img.id=="switch") { 
        hasbeenclicked=false;
        if ( img.src==fullurl+"graph_meso.png"){
            changeButton("graph_macro.png");   
            pushSWClick(swclickActual);
            changeToMeso(swclickActual);
            hasbeenclicked=true;       
        }
        if ( img.src==fullurl+"graph_macro.png" && hasbeenclicked==false){
            changeButton("graph_meso.png");    
            pushSWClick(swclickActual);
            changeToMacro(swclickActual);
        }
    }
}

//obsolete
function neweffectshow(){
    if(!is_empty(selections)){    
        $("#labelchange").show();
        $("#availableView").show();  
    }
}

//obsolete
function neweffecthide(){
    $.doTimeout(300,function (){
        if($("#labelchange")[0].hidden==false){
            
        }
        else {
            $("#labelchange").hide();
            $("#availableView").hide(); 
        }
    });
}

//obsolete
function justhide(){    
    $("#labelchange").hide();
    $("#availableView").hide();  
}

//============================= </ NEW BUTTONS > =============================//







//=========================== < FILTERS-SLIDERS > ===========================//

//	EdgeWeightFilter("#sliderAEdgeWeight", "label" , "nodes1", "weight");
//	EdgeWeightFilter("#sliderBEdgeWeight", "label" , "nodes2", "weight");
function EdgeWeightFilter(sliderDivID , type_attrb , type ,  criteria) {

	if ($(sliderDivID).html()!="") {
		pr("\t\t\t\t\t\t[[ algorithm not applied "+sliderDivID+" ]]")
		return;
	}
	// sliderDivID = "#sliderAEdgeWeight"
	// type = "nodes1"
	// type_attrb = "label"
	// criteria = "weight"

	// sliderDivID = "#sliderBNodeSize"
	// type = "NGram"
	// type_attrb = "type"
	// criteria = "size"

	// AlgorithmForSliders ( partialGraph._core.graph.edges , "label" , "nodes1" , "weight") 
	// AlgorithmForSliders ( partialGraph._core.graph.edges , "label" , "nodes2" , "weight") 
	// AlgorithmForSliders ( partialGraph._core.graph.nodes , "type" ,  "Document" ,  "size") 
	// AlgorithmForSliders ( partialGraph._core.graph.nodes , "type" ,  "NGram" ,  "size")
    var filterparams = AlgorithmForSliders ( partialGraph._core.graph.edges , type_attrb , type , criteria) 
    var steps = filterparams["steps"]
    var finalarray = filterparams["finalarray"]
    
    //finished
    $(sliderDivID).freshslider({
        range: true,
        step: 1,
        min:0,
        bgcolor: (type=="nodes1")?"#27c470":"#FFA500" ,
        max:steps-1,
        value:[0,steps-1],
        onchange:function(low, high){    
            var filtervalue = low+"-"+high
            
            if(filtervalue!=lastFilter[sliderDivID]) {
                if(lastFilter[sliderDivID]=="-") {
                    pushFilterValue( sliderDivID , filtervalue )
                    return false
                }
                // $.doTimeout(300,function (){

                for(var i in finalarray) {
                    ids = finalarray[i]
                    if(i>=low && i<=high){
                        for(var id in ids) {                            
                            ID = ids[id]
                            // partialGraph._core.graph.edgesIndex[ID].lock=false;
                            // partialGraph._core.graph.edgesIndex[ID].hidden=false;
                            add1Edge(ID)
                            Edges[ID].lock = false;
                        }
                    } else {
                        for(var id in ids) {
                            ID = ids[id]
                            // partialGraph._core.graph.edgesIndex[ID].lock=true;
                            // partialGraph._core.graph.edgesIndex[ID].hidden=true;
                            partialGraph.dropEdge(ID)
                            Edges[ID].lock = true;
                        }
                    }
                }
                pushFilterValue(sliderDivID,filtervalue)

                if (!is_empty(selections))
                    DrawAsSelectedNodes(selections)



                partialGraph.refresh()
                partialGraph.draw()
                // });
            }
            
        }
    });
}

// NodeWeightFilter ( "#sliderANodeWeight" ,  "Document" , "type" , "size") 
// NodeWeightFilter ( "#sliderBNodeWeight" ,  "NGram" , "type" , "size") 
function NodeWeightFilter(sliderDivID , type_attrb , type ,  criteria) {

	if ($(sliderDivID).html()!="") {
		pr("\t\t\t\t\t\t[[ algorithm not applied "+sliderDivID+" ]]")
		return;
	}
	// sliderDivID = "#sliderAEdgeWeight"
	// type = "nodes1"
	// type_attrb = "label"
	// criteria = "weight"

	// sliderDivID = "#sliderBNodeSize"
	// type = "NGram"
	// type_attrb = "type"
	// criteria = "size"

	// AlgorithmForSliders ( partialGraph._core.graph.edges , "label" , "nodes1" , "weight") 
	// AlgorithmForSliders ( partialGraph._core.graph.edges , "label" , "nodes2" , "weight") 
	// AlgorithmForSliders ( partialGraph._core.graph.nodes , "type" ,  "Document" ,  "size") 
	// AlgorithmForSliders ( partialGraph._core.graph.nodes , "type" ,  "NGram" ,  "size")
    var filterparams = AlgorithmForSliders ( partialGraph._core.graph.nodes , type_attrb , type , criteria) 
    var steps = filterparams["steps"]
    var finalarray = filterparams["finalarray"]
    
    //finished
    $(sliderDivID).freshslider({
        range: true,
        step: 1,
        min:0,
        max:steps-1,
        bgcolor:(type_attrb=="Document")?"#27c470":"#FFA500" ,
        value:[0,steps-1],
        onchange:function(low, high){    
            var filtervalue = low+"-"+high
            
            if(filtervalue!=lastFilter[sliderDivID]) {
                if(lastFilter[sliderDivID]=="-") {
                    pushFilterValue( sliderDivID , filtervalue )
                    return false
                }
                // $.doTimeout(300,function (){

                for(var i in finalarray) {
                    ids = finalarray[i]
                    if(i>=low && i<=high){
                        for(var id in ids) {
                            ID = ids[id]
                            partialGraph._core.graph.nodesIndex[ID].hidden = false;
                        }
                    } else {
                        for(var id in ids) {
                            ID = ids[id]
                            partialGraph._core.graph.nodesIndex[ID].hidden = true;
                        }                     
                    }
                }
                pushFilterValue(sliderDivID,filtervalue)

                if (!is_empty(selections))
                    DrawAsSelectedNodes(selections)

                partialGraph.refresh()
                partialGraph.draw()
                // });
            }
            
        }
    });
}


// AlgorithmForSliders ( partialGraph._core.graph.edges , "label" , "nodes1" , "weight") 
// AlgorithmForSliders ( partialGraph._core.graph.edges , "label" , "nodes2" , "weight") 
// AlgorithmForSliders ( partialGraph._core.graph.nodes , "type" ,  "Document" ,  "size") 
// AlgorithmForSliders ( partialGraph._core.graph.nodes , "type" ,  "NGram" ,  "size") 
function AlgorithmForSliders( elements , type_attrb , type , criteria) {
	// //  ( 1 )
    // // get visible sigma nodes|edges
    elems=elements.filter(function(e) {
                return e[type_attrb]==type;
    });

    // pr("nodes|edges length: "+elems.length)
    // //  ( 2 )
    // // extract [ "edgeID" : edgeWEIGHT ] | [ "nodeID" : nodeSIZE ] 
    // // and save this into edges_weight | nodes_size
    var elem_attrb=[]
    for (var i in elems) {
        e = elems[i]
        id = e.id
        elem_attrb[id]=e[criteria]
        // pr(id+"\t:\t"+e[criteria])
    }
    // pr("{ id : size|weight } ")
    // pr(elem_attrb)

    // //  ( 3 )
    // // order dict edges_weight by edge weight | nodes_size by node size
    var result = ArraySortByValue(elem_attrb, function(a,b){
        return a-b
        //ASCENDENT
    });

    // pr("result: ")
    // pr(result)
    // pr(result.length)
    // // ( 4 )
    // // printing ordered ASC by weigth
    // for (var i in result) {
    //     r = result[i]
    //     idid = r.key
    //     elemattrb = r.value
    //     pr(idid+"\t:\t"+elemattrb)
    //     // e = result[i]
    //     // pr(e[criteria])
    // }
    var N = result.length
    var magnitude = (""+N).length //order of magnitude of edges|nodes
    var exponent = magnitude - 1
    var steps = Math.pow(10,exponent) //    #(10 ^ magnit-1) steps
    var stepsize = Math.round(N/steps)// ~~(visibledges / #steps)

    // pr("-----------------------------------")
    // pr("number of visible nodes|edges: "+N); 
    // pr("magnitude : "+magnitude)
    // pr("number of steps : "+steps)
    // pr("size of one step : "+stepsize)
    // pr("-----------------------------------")
    

    var finalarray = []
    var counter=0
    for(var i = 0; i < steps*2; i++) {
        // pr(i)
        var IDs = []
        for(var j = 0; j < stepsize; j++)  {
            if(!isUndef(result[counter])) {
                k = result[counter].key
                // w = result[counter].value
                // pr("\t["+counter+"] : "+w)
                IDs.push(k)
            }
            counter++;
        }
        if(IDs.length==0) break;
        finalarray[i] = IDs
    }
    // pr("finalarray: ")
    return {"steps":finalarray.length,"finalarray":finalarray}
}

//=========================== </ FILTERS-SLIDERS > ===========================//










//============================= < SEARCH > =============================//
function updateSearchLabels(id,name,type){    
    labels.push({
        'id' : id,
        'label' : name, 
        'desc': type
    });
}

function extractContext(string, context) {
    var matched = string.toLowerCase().indexOf(context.toLowerCase());

    if (matched == -1) 
        return string.slice(0, 20) + '...';

    var begin_pts = '...', end_pts = '...';

    if (matched - 20 > 0) {
        var begin = matched - 20;
    } else {
        var begin = 0;
        begin_pts = '';
    }

    if (matched + context.length + 20 < string.length) {
        var end = matched + context.length + 20;
    } else {
        var end = string.length;
        end_pts = '';
    }

    str = string.slice(begin, end);

    if (str.indexOf(" ") != Math.max(str.lastIndexOf(" "), str.lastIndexOf(".")))
        str = str.slice(str.indexOf(" "), Math.max(str.lastIndexOf(" "), str.lastIndexOf(".")));

    return begin_pts + str + end_pts;
}

function searchLabel(string){    
    var id_node = '';
    var n;
    
    nds = partialGraph._core.graph.nodes.filter(function(x){return !x["hidden"]});
    for(var i in nds){
        n = nds[i]
            if (n.label == string) {
                return n;
            }
    }
}

function search(string) {
    var id_node = '';
    partialGraph.iterNodes(function (n) {
        if(!n.hidden){
            if (n.label == string) {
                id_node = n.id;
                return n;
            }  
        }
    });
    // getOpossitesNodes(id_node, false);
    
    $.doTimeout(30,function (){
        MultipleSelection(id_node);
    });
    // if(categoriesIndex.length==1) updateLeftPanel_uni();
    // if(categoriesIndex.length==2) updateLeftPanel_fix(); 
    
      
                // if(is_empty(selections)==true){  
                //     $("#names").html("");
                //     $("#opossiteNodes").html("");
                //     $("#information").html("");
                //     changeButton("unselectNodes");
                // }
                // else {
                //     greyEverything();
                //     overNodes=true;
                //     for(var i in selections){
                //         markAsSelected(i,true);
                //     }
                //     changeButton("selectNode");
                //     partialGraph.draw();
                // }
                $("input#searchinput").val("");
                $("input#searchinput").autocomplete( "close" );
}

//============================ < / SEARCH > ============================//
