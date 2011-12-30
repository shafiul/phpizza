var NAVTREE =
[
  [ "PHPizza", "index.html", [
    [ "Data Structures", "annotated.html", [
      [ "Authentication", "class_authentication.html", null ],
      [ "Blocks", "class_blocks.html", null ],
      [ "Config", "class_config.html", null ],
      [ "Core", "class_core.html", null ],
      [ "CoreController", "class_core_controller.html", null ],
      [ "CoreForm", "class_core_form.html", null ],
      [ "CoreModel", "class_core_model.html", null ],
      [ "CoreValidator", "class_core_validator.html", null ],
      [ "CoreView", "class_core_view.html", null ],
      [ "Files", "class_files.html", null ],
      [ "Funcs", "class_funcs.html", null ],
      [ "GenericDB", "class_generic_d_b.html", null ],
      [ "Html", "class_html.html", null ],
      [ "MaliciousClass", "class_malicious_class.html", null ],
      [ "MySQL", "class_my_s_q_l.html", null ],
      [ "PHPizza", "class_p_h_pizza.html", null ],
      [ "Template", "class_template.html", null ],
      [ "Validator", "class_validator.html", null ]
    ] ],
    [ "Data Structure Index", "classes.html", null ],
    [ "Class Hierarchy", "hierarchy.html", [
      [ "Authentication", "class_authentication.html", null ],
      [ "Config", "class_config.html", null ],
      [ "Core", "class_core.html", null ],
      [ "CoreController", "class_core_controller.html", null ],
      [ "CoreForm", "class_core_form.html", null ],
      [ "CoreModel", "class_core_model.html", null ],
      [ "CoreValidator", "class_core_validator.html", [
        [ "Validator", "class_validator.html", null ]
      ] ],
      [ "CoreView", "class_core_view.html", [
        [ "Template", "class_template.html", null ]
      ] ],
      [ "Files", "class_files.html", null ],
      [ "Funcs", "class_funcs.html", null ],
      [ "GenericDB", "class_generic_d_b.html", [
        [ "MySQL", "class_my_s_q_l.html", null ]
      ] ],
      [ "Html", "class_html.html", [
        [ "Blocks", "class_blocks.html", null ]
      ] ],
      [ "MaliciousClass", "class_malicious_class.html", null ],
      [ "PHPizza", "class_p_h_pizza.html", null ]
    ] ],
    [ "Data Fields", "functions.html", null ],
    [ "File List", "files.html", [
      [ "config.php", null, null ],
      [ "index.php", null, null ],
      [ "post_script.php", "post__script_8php.html", null ],
      [ "pre_script.php", "pre__script_8php.html", null ],
      [ "userconfig.php", null, null ],
      [ "core/class/Core.php", null, null ],
      [ "core/class/CoreController.php", null, null ],
      [ "core/class/CoreForm.php", null, null ],
      [ "core/class/CoreModel.php", null, null ],
      [ "core/class/CoreValidator.php", null, null ],
      [ "core/class/CoreView.php", null, null ],
      [ "core/class/Funcs.php", null, null ],
      [ "core/class/Html.php", null, null ],
      [ "core/class/db/GenericDB.php", null, null ],
      [ "core/class/db/MySQL.php", null, null ],
      [ "core/funcs/general.php", "general_8php.html", null ],
      [ "custom/class/Authentication.php", null, null ],
      [ "custom/class/Blocks.php", null, null ],
      [ "custom/class/Files.php", null, null ],
      [ "custom/class/MaliciousClass.php", null, null ],
      [ "custom/class/Validator.php", null, null ],
      [ "templates/WhiteLove/index.php", null, null ],
      [ "templates/WhiteLove/Template.php", null, null ]
    ] ],
    [ "Directories", "dirs.html", [
      [ "core", "dir_a75af976d1a462a513ef450ae5a6ac44.html", [
        [ "class", "dir_27c51e58273c65a7b9beb6e341c153fe.html", [
          [ "db", "dir_04c859e399aa73607ddecc4ba0346483.html", null ]
        ] ],
        [ "funcs", "dir_7adad406ed1268bb18b11aea3b4cf796.html", null ]
      ] ],
      [ "custom", "dir_f77d15040423d00a335e9c0c2e0504cb.html", [
        [ "class", "dir_b0602b087c1d217a0278d05e42ca8be0.html", null ]
      ] ],
      [ "templates", "dir_24a36ed97f6cfd5e99cc9aa4aa6824b7.html", [
        [ "WhiteLove", "dir_bdaee5cc0deb19e7d163bd2a26b0f319.html", null ]
      ] ]
    ] ],
    [ "Globals", "globals.html", null ]
  ] ]
];

function createIndent(o,domNode,node,level)
{
  if (node.parentNode && node.parentNode.parentNode)
  {
    createIndent(o,domNode,node.parentNode,level+1);
  }
  var imgNode = document.createElement("img");
  if (level==0 && node.childrenData)
  {
    node.plus_img = imgNode;
    node.expandToggle = document.createElement("a");
    node.expandToggle.href = "javascript:void(0)";
    node.expandToggle.onclick = function() 
    {
      if (node.expanded) 
      {
        $(node.getChildrenUL()).slideUp("fast");
        if (node.isLast)
        {
          node.plus_img.src = node.relpath+"ftv2plastnode.png";
        }
        else
        {
          node.plus_img.src = node.relpath+"ftv2pnode.png";
        }
        node.expanded = false;
      } 
      else 
      {
        expandNode(o, node, false);
      }
    }
    node.expandToggle.appendChild(imgNode);
    domNode.appendChild(node.expandToggle);
  }
  else
  {
    domNode.appendChild(imgNode);
  }
  if (level==0)
  {
    if (node.isLast)
    {
      if (node.childrenData)
      {
        imgNode.src = node.relpath+"ftv2plastnode.png";
      }
      else
      {
        imgNode.src = node.relpath+"ftv2lastnode.png";
        domNode.appendChild(imgNode);
      }
    }
    else
    {
      if (node.childrenData)
      {
        imgNode.src = node.relpath+"ftv2pnode.png";
      }
      else
      {
        imgNode.src = node.relpath+"ftv2node.png";
        domNode.appendChild(imgNode);
      }
    }
  }
  else
  {
    if (node.isLast)
    {
      imgNode.src = node.relpath+"ftv2blank.png";
    }
    else
    {
      imgNode.src = node.relpath+"ftv2vertline.png";
    }
  }
  imgNode.border = "0";
}

function newNode(o, po, text, link, childrenData, lastNode)
{
  var node = new Object();
  node.children = Array();
  node.childrenData = childrenData;
  node.depth = po.depth + 1;
  node.relpath = po.relpath;
  node.isLast = lastNode;

  node.li = document.createElement("li");
  po.getChildrenUL().appendChild(node.li);
  node.parentNode = po;

  node.itemDiv = document.createElement("div");
  node.itemDiv.className = "item";

  node.labelSpan = document.createElement("span");
  node.labelSpan.className = "label";

  createIndent(o,node.itemDiv,node,0);
  node.itemDiv.appendChild(node.labelSpan);
  node.li.appendChild(node.itemDiv);

  var a = document.createElement("a");
  node.labelSpan.appendChild(a);
  node.label = document.createTextNode(text);
  a.appendChild(node.label);
  if (link) 
  {
    a.href = node.relpath+link;
  } 
  else 
  {
    if (childrenData != null) 
    {
      a.className = "nolink";
      a.href = "javascript:void(0)";
      a.onclick = node.expandToggle.onclick;
      node.expanded = false;
    }
  }

  node.childrenUL = null;
  node.getChildrenUL = function() 
  {
    if (!node.childrenUL) 
    {
      node.childrenUL = document.createElement("ul");
      node.childrenUL.className = "children_ul";
      node.childrenUL.style.display = "none";
      node.li.appendChild(node.childrenUL);
    }
    return node.childrenUL;
  };

  return node;
}

function showRoot()
{
  var headerHeight = $("#top").height();
  var footerHeight = $("#nav-path").height();
  var windowHeight = $(window).height() - headerHeight - footerHeight;
  navtree.scrollTo('#selected',0,{offset:-windowHeight/2});
}

function expandNode(o, node, imm)
{
  if (node.childrenData && !node.expanded) 
  {
    if (!node.childrenVisited) 
    {
      getNode(o, node);
    }
    if (imm)
    {
      $(node.getChildrenUL()).show();
    } 
    else 
    {
      $(node.getChildrenUL()).slideDown("fast",showRoot);
    }
    if (node.isLast)
    {
      node.plus_img.src = node.relpath+"ftv2mlastnode.png";
    }
    else
    {
      node.plus_img.src = node.relpath+"ftv2mnode.png";
    }
    node.expanded = true;
  }
}

function getNode(o, po)
{
  po.childrenVisited = true;
  var l = po.childrenData.length-1;
  for (var i in po.childrenData) 
  {
    var nodeData = po.childrenData[i];
    po.children[i] = newNode(o, po, nodeData[0], nodeData[1], nodeData[2],
        i==l);
  }
}

function findNavTreePage(url, data)
{
  var nodes = data;
  var result = null;
  for (var i in nodes) 
  {
    var d = nodes[i];
    if (d[1] == url) 
    {
      return new Array(i);
    }
    else if (d[2] != null) // array of children
    {
      result = findNavTreePage(url, d[2]);
      if (result != null) 
      {
        return (new Array(i).concat(result));
      }
    }
  }
  return null;
}

function initNavTree(toroot,relpath)
{
  var o = new Object();
  o.toroot = toroot;
  o.node = new Object();
  o.node.li = document.getElementById("nav-tree-contents");
  o.node.childrenData = NAVTREE;
  o.node.children = new Array();
  o.node.childrenUL = document.createElement("ul");
  o.node.getChildrenUL = function() { return o.node.childrenUL; };
  o.node.li.appendChild(o.node.childrenUL);
  o.node.depth = 0;
  o.node.relpath = relpath;

  getNode(o, o.node);

  o.breadcrumbs = findNavTreePage(toroot, NAVTREE);
  if (o.breadcrumbs == null)
  {
    o.breadcrumbs = findNavTreePage("index.html",NAVTREE);
  }
  if (o.breadcrumbs != null && o.breadcrumbs.length>0)
  {
    var p = o.node;
    for (var i in o.breadcrumbs) 
    {
      var j = o.breadcrumbs[i];
      p = p.children[j];
      expandNode(o,p,true);
    }
    p.itemDiv.className = p.itemDiv.className + " selected";
    p.itemDiv.id = "selected";
    $(window).load(showRoot);
  }
}

