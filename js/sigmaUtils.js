
function getnodes(){
    return partialGraph._core.graph.nodes;
}

function getnodesIndex(){
    return partialGraph._core.graph.nodesIndex;
}

function getedges(){
    return partialGraph._core.graph.edges;
}

function getedgesIndex(){
    return partialGraph._core.graph.edgesIndex;
}

function getn(id){
    return partialGraph._core.graph.nodesIndex[id];
}

function gete(id){
    return partialGraph._core.graph.edgesIndex[id];
}

function find(label){
    results=[];
    nds=getnodesIndex();
    for(var i in nds){
        n=nds[i];
        if(n.hidden==false){
            if (n.label.indexOf(label)!==-1) {
                results.push(n);
            }  
        }
    }
    return results;
}

function exactfind(label) {
    nds=getnodesIndex();
    for(var i in nds){
        n=nds[i];
        if(n.hidden==false){
            if (n.label==label) {
                return n;
            }
        }
    }
    return null;
}

function cloneObject(source) {
    for (i in source) {
        if (typeof source[i] == 'source') {
            this[i] = new cloneObject(source[i]);
        }
        else{
            this[i] = source[i];
	}
    }
}

function getSelections(){    
        params=[];
        for(var i in selections){
            params.push(Nodes[i].label);
        }
        return params;
}

function getNeighs(sels,arr){ 
    neighDict={};
    for(var i in sels) {
        A=arr[i].neighbours;
        for(var j in A){
            neighDict[A[j]]=1
        }
        neighDict[i]=1;
    }    
    return neighDict;
}