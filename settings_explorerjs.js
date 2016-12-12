/*
 * Customize as you want ;)
 */

// ============ < DEVELOPER OPTIONS > ============
var geomap=false;
var minimap=false;
var getAdditionalInfo=false;//for topPapers div


var mainfile=false;
// ourGetUrlParam.file = "data/testgraph.json";

var dataFolderTree = {};
var gexfDict={};
var egonode = {}
var iwantograph = "";

var bridge={};
external="";
//external="http://tina.iscpif.fr/explorerjs/";//Just if you want to use the server-apps from tina.server
bridge["forFilteredQuery"] = "comexAPI" //external+"php/bridgeClientServer_filter.php";
bridge["forNormalQuery"] = "comexAPI" //external+"php/bridgeClientServer.php";




ircNick="";
ircCHN="";

var catSoc = "Document";
var catSem = "NGram";

var sizeMult = [];
    sizeMult[catSoc] = 0.0;
    sizeMult[catSem] = 0.0;

var inactiveColor = '#666';
var startingNodeId = "1";
var minLengthAutoComplete = 1;
var maxSearchResults = 10;
var strSearchBar = "Search";

var cursor_size_min= 0;
var cursor_size= 0;
var cursor_size_max= 100;

var desirableTagCloudFont_MIN=12;
var desirableTagCloudFont_MAX=20;
var desirableNodeSizeMIN=1;
var desirableNodeSizeMAX=12;
var desirableScholarSize=6; //Remember that all scholars have the same size!

/*
 *Three states:
 *  - true: fa2 running at start
 *  - false: fa2 stopped at start, button exists
 *  - "off": button doesn't exist, fa2 stopped forever
 **/ var fa2enabled=false;//"off";
var stopcriteria = false;
var iterationsFA2=1000;
var seed=999999999;//defaultseed
var semanticConverged=false;


var showLabelsIfZoom=2.0;
var greyColor = "#9b9e9e";

// ============ < SIGMA.JS PROPERTIES > ============

var sigmaJsDrawingProperties = {
    defaultLabelColor: 'black',
    defaultLabelSize: 10,//in fact I'm using it as minLabelSize'
    defaultLabelBGColor: '#fff',
    defaultLabelHoverColor: '#000',
    labelThreshold: 6,
    defaultEdgeType: 'curve',

    borderSize: 2.5,//Something other than 0
    nodeBorderColor: "default",//exactly like this
    defaultNodeBorderColor: "black"//,//Any color of your choice
    //defaultBorderView: "always"
};
var sigmaJsGraphProperties = {
    minEdgeSize: 2,
    maxEdgeSize: 2
};
var sigmaJsMouseProperties = {
    minRatio:0.1,
    maxRatio: 15
};
// ============ < / SIGMA.JS PROPERTIES > ============


// ============ < / DEVELOPER OPTIONS > ============



// ============ < VARIABLES.JS > ============
//"http://webchat.freenode.net/?nick=Ademe&channels=#anoe"
var ircUrl="http://webchat.freenode.net/?nick="+ircNick+"&channels="+ircCHN;
var twjs="tinawebJS/";
var categories = {};
var categoriesIndex = [];

var gexf;
//var zoom=0;

var checkBox=false;
var overNodes=false;
var shift_key=false;

var NOW="A";
var PAST="--";

var swclickActual="";
var swclickPrev="";
var swMacro=true;

var socsemFlag=false;
var constantNGramFilter;

// var nodeFilterA_past = ""
// var nodeFilterA_now = ""

// var nodeFilterB_past = ""
// var nodeFilterB_now = ""

var lastFilter = []
    lastFilter["#sliderBNodeWeight"] = "-"
    lastFilter["#sliderAEdgeWeight"] = "-"
    lastFilter["#sliderBEdgeWeight"] = "-"

// var edgeFilterB_past = ""
// var edgeFilterB_now = ""



var overviewWidth = 200;
var overviewHeight = 175;
var overviewScale = 0.25;
var overviewHover=false;
var moveDelay = 80, zoomDelay = 2;
//var Vecindad;
var partialGraph;
var otherGraph;
var Nodes = [];
var Edges = [];

var nodeslength=0;

var labels = [];

var numberOfDocs=0;
var numberOfNGrams=0;

var selections = [];
var deselections={};
var opossites = {};
var opos=[];
var oposMAX;

var matches = [];

var nodes1 = [];
var nodes2 = [];
var bipartiteD2N = [];
var bipartiteN2D = [];

var flag=0;
var firstime=0;
var leftright=true;
var edgesTF=false;

//This variables will be updated in sigma.parseCustom.js
var minNodeSize=1.00;
var maxNodeSize=5.00;
var minEdgeWeight=5.0;
var maxEdgeWeight=0.0;
//---------------------------------------------------

var bipartite=false;
var gexfDictReverse={}
for (var i in gexfDict){
    gexfDictReverse[gexfDict[i]]=i;
}

var colorList = ["#000000", "#FFFF00", "#1CE6FF", "#FF34FF", "#FF4A46", "#008941", "#006FA6", "#A30059", "#FFDBE5", "#7A4900", "#0000A6", "#63FFAC", "#B79762", "#004D43", "#8FB0FF", "#997D87", "#5A0007", "#809693", "#FEFFE6", "#1B4400", "#4FC601", "#3B5DFF", "#4A3B53", "#FF2F80", "#61615A", "#BA0900", "#6B7900", "#00C2A0", "#FFAA92", "#FF90C9", "#B903AA", "#D16100", "#DDEFFF", "#000035", "#7B4F4B", "#A1C299", "#300018", "#0AA6D8", "#013349", "#00846F", "#372101", "#FFB500", "#C2FFED", "#A079BF", "#CC0744", "#C0B9B2", "#C2FF99", "#001E09", "#00489C", "#6F0062", "#0CBD66", "#EEC3FF", "#456D75", "#B77B68", "#7A87A1", "#788D66", "#885578", "#FAD09F", "#FF8A9A", "#D157A0", "#BEC459", "#456648", "#0086ED", "#886F4C","#34362D", "#B4A8BD", "#00A6AA", "#452C2C", "#636375", "#A3C8C9", "#FF913F", "#938A81", "#575329", "#00FECF", "#B05B6F", "#8CD0FF", "#3B9700", "#04F757", "#C8A1A1", "#1E6E00", "#7900D7", "#A77500", "#6367A9", "#A05837", "#6B002C", "#772600", "#D790FF", "#9B9700", "#549E79", "#FFF69F", "#201625", "#72418F", "#BC23FF", "#99ADC0", "#3A2465", "#922329", "#5B4534", "#FDE8DC", "#404E55", "#0089A3", "#CB7E98", "#A4E804", "#324E72", "#6A3A4C", "#83AB58", "#001C1E", "#D1F7CE", "#004B28", "#C8D0F6", "#A3A489", "#806C66", "#222800", "#BF5650", "#E83000", "#66796D", "#DA007C", "#FF1A59", "#8ADBB4", "#1E0200", "#5B4E51", "#C895C5", "#320033", "#FF6832", "#66E1D3", "#CFCDAC", "#D0AC94", "#7ED379", "#012C58"];

var RVUniformC = function(seed){
    this.a=16807;
    this.b=0;
    this.m=2147483647;
    this.u;
    this.seed=seed;
    this.x = this.seed;
    //    this.generar = function(n){
    //        uniforme = [];
    //        x = 0.0;
    //        x = this.seed;
    //        for(i = 1; i < n ; i++){
    //            x = ((x*this.a)+this.b)%this.m;
    //            uniforme[i] = x/this.m;
    //        }
    //        return uniforme;
    //    };
    this.getRandom = function(){
        x = ((this.x*this.a)+this.b)%this.m;
        this.x = x;
        this.u = this.x/this.m;
        return this.u;
    };
}
//unifCont = new RVUniformC(100000000)
