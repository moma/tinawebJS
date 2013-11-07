
function trackMouse() {
    var ctx = partialGraph._core.domElements.mouse.getContext('2d');
    ctx.globalCompositeOperation = "source-over";
    ctx.clearRect(0, 0, partialGraph._core.domElements.nodes.width, partialGraph._core.domElements.nodes.height);

    x = partialGraph._core.mousecaptor.mouseX;
    y = partialGraph._core.mousecaptor.mouseY;
    
    ctx.strokeStyle = '#000';
    ctx.lineWidth = 1;
    ctx.beginPath();
    ctx.arc(x, y, cursor_size, 0, Math.PI * 2, true);
    //ctx.arc(partialGraph._core.width/2, partialGraph._core.height/2, 4, 0, 2 * Math.PI, true);/*todel*/
    ctx.closePath();
    ctx.stroke();
    
};

function changeGraphPosition(evt, echelle) {
    document.body.style.cursor = "move";
    var _coord = {
        x : evt.pageX,
        y : evt.pageY
    };
    console.log("changeGraphPosition... cordx: "+_coord.x+" - cordy: "+_coord.y);
    partialGraph.centreX += ( partialGraph.lastMouse.x - _coord.x ) / echelle;
    partialGraph.centreY += ( partialGraph.lastMouse.y - _coord.y ) / echelle;
    partialGraph.lastMouse = _coord;
}

function onOverviewMove(evt) {
    console.log("onOverViewMove"); 
    /*
     pageX: 1247   pageY: 216
     screenX: 1188  screenY: 307
    
     pageX: 1444    pageY: 216
     screenX: 1365  screenY: 307
     */
    
    if (partialGraph.dragOn) {
        changeGraphPosition(evt,-overviewScale);
    }
}

function startMove(evt){
    console.log("startMove");
    evt.preventDefault();
    partialGraph.dragOn = true;
    partialGraph.lastMouse = {
        x : evt.pageX,
        y : evt.pageY
    }
    partialGraph.mouseHasMoved = false;
}

function endMove(evt){
    console.log("endMove");
    document.body.style.cursor = "default";
    partialGraph.dragOn = false;
    partialGraph.mouseHasMoved = false;
}

function onGraphScroll(evt, delta) {
    partialGraph.totalScroll += delta;
    if (Math.abs(partialGraph.totalScroll) >= 1) {
        if (partialGraph.totalScroll < 0) {
            //ZoomOUT
            if (partialGraph.position().ratio > sigmaJsMouseProperties.minRatio) {
                //partialGraph.zoomTo(partialGraph._core.width / 2, partialGraph._core.height / 2, partialGraph._core.mousecaptor.ratio * 0.5);
                //var _el = $(this),
                //_off = $(this).offset(),
                //_deltaX = evt.pageX - _el.width() / 2 - _off.left,
                //_deltaY = evt.pageY - _el.height() / 2 - _off.top;
                var 
                mx=evt.offsetX,
                my=evt.offsetY;
                partialGraph.centreX=mx*((partialGraph._core.width-1)/(overviewWidth)),
                partialGraph.centreY=my*((partialGraph._core.height-1)/(overviewHeight));               
                
                //                console.log("mx: "+mx+" - my: "+ my);                
                //                console.log("cx: "+cx+" - cy: "+ cy);
                //                partialGraph.centreX =cx;
                //                partialGraph.centreY =cy;
                partialGraph.zoomTo(partialGraph.centreX, partialGraph.centreY, partialGraph._core.mousecaptor.ratio * 0.5);
                //                partialGraph.centreX -= ( Math.SQRT2 - 1 ) * _deltaX / partialGraph.echelleGenerale;
                //                partialGraph.centreY -= ( Math.SQRT2 - 1 ) * _deltaY / partialGraph.echelleGenerale;
                //                partialGraph.zoomTo(partialGraph._core.width / 2, partialGraph._core.height / 2, partialGraph._core.mousecaptor.ratio * 0.5);
                $("#zoomSlider").slider("value",partialGraph.position().ratio);
            }
        } else {
            //ZoomIN
            if (partialGraph.position().ratio < sigmaJsMouseProperties.maxRatio) {
                //                partialGraph.zoomTo(partialGraph._core.width / 2, partialGraph._core.height / 2, partialGraph._core.mousecaptor.ratio * 1.5);
                //                partialGraph.echelleGenerale = Math.pow( Math.SQRT2, partialGraph.position().ratio );
                //var _el = $(this),
                //_off = $(this).offset(),
                //_deltaX = evt.pageX - _el.width() / 2 - _off.left,
                //_deltaY = evt.pageY - _el.height() / 2 - _off.top;
                var 
                mx=evt.offsetX,
                my=evt.offsetY;
                partialGraph.centreX=mx*((partialGraph._core.width-1)/(overviewWidth)),
                partialGraph.centreY=my*((partialGraph._core.height-1)/(overviewHeight));               
                
                //                console.log("mx: "+mx+" - my: "+ my);                
                //                console.log("cx: "+cx+" - cy: "+ cy);
                //                partialGraph.centreX =cx;
                //                partialGraph.centreY =cy;
                partialGraph.zoomTo(partialGraph.centreX, partialGraph.centreY, partialGraph._core.mousecaptor.ratio * 1.5);
                $("#zoomSlider").slider("value",partialGraph.position().ratio);
            }
        }
        partialGraph.totalScroll = 0;
    }
}

function initializeMap() {
    clearInterval(partialGraph.timeRefresh);
    partialGraph.oldParams = {};
    $("#zoomSlider").slider({
        orientation: "vertical",
        value: partialGraph.position().ratio,
        min: sigmaJsMouseProperties.minRatio,
        max: sigmaJsMouseProperties.maxRatio,
        range: "min",
        step: 0.1,
        slide: function( event, ui ) {
            partialGraph.zoomTo(
                partialGraph._core.width / 2, 
                partialGraph._core.height / 2, 
                ui.value);
        }
    });
    $("#overviewzone").css({
        width : overviewWidth + "px",
        height : overviewHeight + "px"
    });
    $("#overview").attr({
        width : overviewWidth,
        height : overviewHeight
    });
    partialGraph.timeRefresh = setInterval(traceMap,60);
}

function updateMap(){
    
    partialGraph.imageMini="";
    partialGraph.ctxMini="";
    partialGraph.ctxMini = document.getElementById('overview').getContext('2d');
    partialGraph.ctxMini.clearRect(0, 0, overviewWidth, overviewHeight);
    
    partialGraph.iterNodes(function(n){
        if(n.hidden==false){
            partialGraph.ctxMini.fillStyle = n.color;
            partialGraph.ctxMini.beginPath();
            numPosibilidades = 2.5 - 0.9;
            aleat = Math.random() * numPosibilidades;
            partialGraph.ctxMini.arc(((n.displayX/1.2)-200)*0.25 , ((n.displayY/1.2)+110)*0.25 , (0.9 + aleat)*0.25+1 , 0 , Math.PI*2 , true);
            //        //console.log(n.x*1000 +" * 0.25"+" _ "+ n.y*1000 +" * 0.25"+" _ "+ (0.9 + aleat) +" * 0.25 + 1");
            //        
            partialGraph.ctxMini.closePath();
            partialGraph.ctxMini.fill();
        }
    //        
    });
    partialGraph.imageMini = partialGraph.ctxMini.getImageData(0, 0, overviewWidth, overviewHeight);
}

function traceMap() {
    //pr("\ttracingmap");
    partialGraph.echelleGenerale = Math.pow( Math.SQRT2, partialGraph.position().ratio );
    partialGraph.ctxMini.putImageData(partialGraph.imageMini, 0, 0);
    
    var _r = 0.25 / partialGraph.echelleGenerale,
    cx =  partialGraph.centreX,
    cy =  partialGraph.centreY,
    _w = _r * partialGraph._core.width,
    _h = _r * partialGraph._core.height;
    partialGraph.ctxMini.strokeStyle = "rgb(220,0,0)";
    partialGraph.ctxMini.lineWidth = 3;
    partialGraph.ctxMini.fillStyle = "rgba(120,120,120,0.2)";
    partialGraph.ctxMini.beginPath();
    partialGraph.ctxMini.fillRect( cx-_w/2, cy-_h/2, _w, _h );
    partialGraph.ctxMini.strokeRect( cx-_w/2, cy-_h/2, _w, _h );
    partialGraph.ctxMini.closePath();
}

function startMiniMap(){
    partialGraph.ctxMini = document.getElementById('overview').getContext('2d'); 
    partialGraph.ctxMini.clearRect(0, 0, overviewWidth, overviewHeight);
    partialGraph.totalScroll=0;    
    partialGraph.centreX = partialGraph._core.width/2;
    partialGraph.centreY = partialGraph._core.heigth/2;
}