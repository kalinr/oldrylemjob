if (document.getElementsByTagName && document.getElementById && document.getElementsByName) {

var srch = {

  init : function() {
    
    this.configEvents();
    
    if (document.addEventListener) {
    
      document.addEventListener("DOMContentLoaded", this.configResults);
    
    }
    
    else if (document.attachEvent) {
    
      document.attachEvent("onreadystatechange", function() { if (document.readyState == "complete") { srch.configResults(); } });      
    
    }
      
  },

  processSearch : function(evt) {
  
    srch.stopDefault(evt);
    if (srch.theQueryField.value !== '') {
      var encodedVal = encodeURIComponent(srch.theQueryField.value);
      location.href = 'https://www.imaginecrafts.com/search/' + encodedVal;
    }
  
  },
  
  updateView : function(evt) {
  
    srch.stopDefault(evt);
    
    var theLink = srch.findTarget(evt, 'a', this);

    if (!theLink) { return; }

    var numberClicked = theLink.firstChild.nodeValue;    
    var resultsContainer = this.parentNode;    
    var theItems = resultsContainer.getElementsByTagName('li');    
    var quantity = theItems.length;    
    var i;
    this.innerHTML = '';
    
    if (numberClicked === 'View all') {
    
      for (i=0; i<quantity; i++) {
      
        theItems[i].style.display = 'block';
      
      }
      numberClicked = 0;
    
    }
    
    else {
    
      if (/NEXT/.test(numberClicked) || /PREV/.test(numberClicked)) {
    
        var theNum = theLink.className.replace("pgis","");
        numberClicked = parseInt(theNum);
    
      }
      
      else {

        numberClicked = parseInt(numberClicked);
 
      }

      var lowerBound = (numberClicked - 1) * 10;
      var upperBound = numberClicked * 10; 
      
      for (i=0; i<quantity; i++) {
      
        if (i >= lowerBound && i < upperBound) {
          theItems[i].style.display = 'block';
        }
        else {
          theItems[i].style.display = 'none';        
        }
      
      }

    }
    
    switch (this.id) {
    
      case 'productPagination' :
        
        srch.generatePagination(srch.productPaginationArea, quantity, numberClicked);
        break;

      case 'projectPagination' :

        srch.generatePagination(srch.projectPaginationArea, quantity, numberClicked);
        break;

      case 'videoPagination' :
      
        srch.generatePagination(srch.videoPaginationArea, quantity, numberClicked);
        break;

    }
    
  },
  
  generatePagination : function(paginationArea, quantity, currentPg) {
  
    var maxPages = quantity / 10;
    maxPages = Math.ceil(maxPages);
  
    if (maxPages == 1 && quantity > 10 && quantity < 20) { maxPages = 2; }
 
    var str = '';
    var thePg = '';

    if (currentPg > 1) {  
      thePg = currentPg - 1;
      str += ' <a href="' + thePg + '" class="pgis' + thePg + '">&lt; PREV</a> ';  
    }      

    if ((currentPg - 3) > 0) {
      str += ' ... ';
    }     
      
    if ((currentPg - 2) > 0) {     
      thePg = currentPg - 2;
      str += '<a href="' + thePg + '">' + thePg + '</a> ';  
    }      

    if ((currentPg - 1) > 0) {
      thePg = currentPg - 1;
      str += '<a href="' + thePg + '">' + thePg + '</a> ';  
    }
          
    if (currentPg > 0) {  
      str += currentPg + ' ';
    }
      
    if ((currentPg + 1) <= maxPages) {     
      thePg = currentPg + 1;
      str += '<a href="' + thePg + '">' + thePg + '</a> ';  
    }
      
    if ((currentPg + 2) <= maxPages) {
      thePg = currentPg + 2;
      str += '<a href="' + thePg + '">' + thePg + '</a> ';  
    }

    if ((currentPg + 3) < maxPages) {     
      str += ' ... ';
    }  

    if (currentPg < maxPages) {
      thePg = currentPg + 1;
      str += ' <a href="' + thePg + '" class="pgis' + thePg + '">NEXT &gt;</a>';
    }
      
    str += ' &nbsp; | &nbsp; <a href="0">View all</a>';
      
    paginationArea.innerHTML = str;
  
  },

  configResults : function() {

    var theForm = document.getElementById('myform');
    srch.theQueryField = document.getElementsByName('query')[0];
    
    if (theForm && srch.theQueryField) {
    
      srch.addEvent(theForm, 'submit', srch.processSearch, false);
    
    }

    var tabHolder = document.getElementById('tabRow');
    var paginationArea;

    if (tabHolder) {

      srch.productsHolder = document.getElementById('productsResults');
      srch.theProducts = srch.productsHolder.getElementsByTagName('li');
      srch.allProducts = srch.theProducts.length;
      srch.productPaginationArea = document.getElementById('productPagination');
      if (srch.allProducts > 10 && srch.productPaginationArea) {
        srch.generatePagination(srch.productPaginationArea, srch.allProducts, 1);
        srch.addEvent(srch.productPaginationArea, 'click', srch.updateView, false);
      }
      
      srch.projectsHolder = document.getElementById('projectsResults');      
      srch.theProjects = srch.projectsHolder.getElementsByTagName('li');
      srch.allProjects = srch.theProjects.length;
      srch.projectPaginationArea = document.getElementById('projectPagination');
      if (srch.allProjects > 10 && srch.projectPaginationArea) {
        srch.generatePagination(srch.projectPaginationArea, srch.allProjects, 1);
        srch.addEvent(srch.projectPaginationArea, 'click', srch.updateView, false);
      }
      
      srch.videosHolder = document.getElementById('videosResults');
      srch.theVideos = srch.videosHolder.getElementsByTagName('li');
      srch.allVideos = srch.theVideos.length;
      srch.videoPaginationArea = document.getElementById('videoPagination');
      if (srch.allVideos > 10 && srch.videoPaginationArea) {
        srch.generatePagination(srch.videoPaginationArea, srch.allVideos, 1);
        srch.addEvent(srch.videoPaginationArea, 'click', srch.updateView, false);
      }

      srch.theTabs = tabHolder.getElementsByTagName('a');
      srch.allTabs = srch.theTabs.length;
      
      for (var i=0; i<srch.allTabs; i++) {
      
        srch.addEvent(srch.theTabs[i], 'click', srch.switchTab, false);
      
      }

      srch.showFirstTen();
      
    }
  
  },
  
  switchTab : function(evt) {
  
    srch.stopDefault(evt);
  
    // clear tabs
    for (var i=0; i<srch.allTabs; i++) {
      srch.theTabs[i].className = '';
    }
    
    // hide results
    srch.productsHolder.style.display = 'none';
    srch.projectsHolder.style.display = 'none';
    srch.videosHolder.style.display = 'none';
    
    // activate clicked tab
    this.className = 'currentTab';
    
    switch (this.id) {
    
      case 'productsTab' :
      
        srch.productsHolder.style.display = 'block';
        break;

      case 'projectsTab' :
      
        srch.projectsHolder.style.display = 'block';
        break;

      case 'videosTab' :
      
        srch.videosHolder.style.display = 'block';
        break;
    
    }
      
  },
  
  showFirstTen : function() {
  
    for (var i=10; i<srch.allProducts; i++) {
    
      srch.theProducts[i].style.display = 'none';
    
    }
    
    for (i=10; i<srch.allProjects; i++) {
    
      srch.theProjects[i].style.display = 'none';
    
    }    

    for (i=10; i<srch.allVideos; i++) {
    
      srch.theVideos[i].style.display = 'none';
    
    }     
  
  },

  configEvents : function() {
    
    if (document.addEventListener) {
    
        this.addEvent = function(el, type, func, capture) {
          el.addEventListener(type, func, capture);  
        };
        this.stopBubble = function(evt) { evt.stopPropagation(); };
        this.stopDefault = function(evt) { evt.preventDefault(); };
        this.findTarget = function(evt, targetNode, container) {
          var currentNode = evt.target;
          while (currentNode && currentNode !== container) {
            if (currentNode.nodeName.toLowerCase() === targetNode) {
                return currentNode; break;
            }
            else { currentNode = currentNode.parentNode; }
          };
          return false;
        };
    }
    
    else if (document.attachEvent) {
    
        this.addEvent = function(el, type, func) {
          el["e" + type + func] = func;
          el[type + func] = function() { el["e" + type + func](window.event); };
          el.attachEvent("on" + type, el[type + func]);
        };
        this.stopBubble = function(evt) { evt.cancelBubble = true; };
        this.stopDefault = function(evt) { evt.returnValue = false; };
        this.findTarget = function(evt, targetNode, container) {
          var currentNode = evt.srcElement;
          while (currentNode && currentNode !== container) {
            if (currentNode.nodeName.toLowerCase() === targetNode) {
                return currentNode; break;
            }
            else { currentNode = currentNode.parentNode; }
          };
          return false;
        };
        
    }
    
  }  

}

srch.init();

}