<!DOCTYPE html>
<html>
  <head>
<meta name="viewport" content="width=750, user-scalable=yes">
    <title>Puzzle &amp; Dragons optimizer</title>
    <script src="/ext/jquery-1.9.1.min.js"></script>
    <script src="/ext/dropzone.min.js"></script>

  <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-54322831-1', 'auto');
  ga('send', 'pageview');

  </script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/basic.css">
<link rel="stylesheet" type="text/css" href="css/dropzone.css">
<link rel="stylesheet" type="text/css" href="css/throbber.css">
<link rel="stylesheet" type="text/css" href="css/border-flash.css">
<meta charset="utf-8"/>
<style>



      @font-face {
      font-family: PnDIcons;
      src: url('fonts/pndicons.eot?') format('eot'),
      url('fonts/pndicons.woff') format('woff'),
      url('fonts/pndicons.ttf') format('truetype'),
      url('fonts/pndicons.svg') format('svg');
      }
      #grid, #path {
      top: 20px;
      left: 20px;
      position: absolute;
      }
      #path { pointer-events: none; z-index: 2; }
      .e0, .e1, .e2, .e3, .e4, .e5, .e6, .eX {
      font-family: PnDIcons;
      text-align: center;
      vertical-align: middle;
      border-radius: 50%;
      width: 1.5em;
      height: 1.5em;
      line-height: 1.5em;
      display: inline-block;
      }
      #grid .e0, #grid .e1, #grid .e2, #grid .e3, #grid .e4, #grid .e5, #grid .e6, #grid .eX {
      font-size: 40px;
      }
      #grid > div { position: absolute; cursor: pointer; }
      #grid > div:nth-child(6n+1) { left: 0px; }
      #grid > div:nth-child(6n+2) { left: 64px; }
      #grid > div:nth-child(6n+3) { left: 128px; }
      #grid > div:nth-child(6n+4) { left: 192px; }
      #grid > div:nth-child(6n+5) { left: 256px; }
      #grid > div:nth-child(6n+6) { left: 320px; }
      .row1 { top: 0px; }
      .row2 { top: 64px; }
      .row3 { top: 128px; }
      .row4 { top: 192px; }
      .row5 { top: 256px; }
      .e0 { background: #b12; color: #f74; }
      .e0::before { content: "\1f525"; /*fire*/ }
      .e1 { background: #15b; color: #8ff; }
      .e1::before { content: "\1f4a7"; /*droplet*/ }
      .e2 { background: #074; color: #4f6; }
      .e2::before { content: "\1f342"; /*leaf*/ }
      .e3 { background: #872; color: #fe5; }
      .e3::before { content: "\2600"; /*sun*/ }
      .e4 { background: #709; color: #d5c; }
      .e4::before { content: "\263e"; /*moon*/ }
      .e5 {
      background: #e28;
      color: #f7d;
      border-radius: 8%;
      margin: 0.1em;
      width: 1.3em;
      height: 1.3em;
      }
      .e5::before { content: "\2665"; /*heart*/ }
      .e6 { background: white; color: navy; }
      .e6::before { content: "\1f608"; /*demon*/ }
      .eX { background: #444; color: #ccc; }
      .eX::before { content: "?"; }
      #profile {
      position: absolute;
      left: 500px;
      top: 20px;
      }
      #profile .e0, #profile .e1, #profile .e2, #profile .e3, #profile .e4, #profile .e6, #profile .e5, #profile .eX {
      font-size: 16px;
      }
      #profile input { width: 8em; }
      #controls {
      position: absolute;
      left: 20px;
      top: 360px;
      width: 380px;
      text-align: center;
      line-height: 2em;
      }
      #extra-controls {
      position: absolute;
      left: 40px;
      top: 480px;
      z-index: 10000;
      }
      #solve {
      width: 180px;
      height: 40px;
      font-size: 1.25em;
      font-weight: bold;
      }
      #status {
      position: absolute;
      top: 520px;
      left: 100px;
      }
      #solutions {
      position: absolute;
      left: 800px;
      top: 20px;
      right: 20px;
      bottom: 20px;
      overflow: scroll;
      }
      #solutions li { padding: 4px; cursor: pointer; }
      #solutions li:hover { background: #cfc; }
      #hand {
      position: absolute;
      background: yellow;
      border: 2px solid black;
      width: 10px;
      height: 10px;
      }
      #import-popup, #change-popup {
      position: absolute;
      border: 3px solid black;
      background: #eee;
      padding: 20px;
      }
      #import-popup {
      width: 400px;
      height: 220px;
      left: 440px;
      top: 190px;
      }
      #change-popup {
      width: 150px;
      height: 430px;
      top: 65px;
      left: 450px;
      font-size: 30px;
      z-index: 10001;
      }
      #import-legend, #change-popup { line-height: 1.6em; }
      #import-textarea {
      position: absolute;
      left: 125px;
      top: 20px;
      font-size: 28px;
      font-family: Consolas, monospace;
      letter-spacing: 28px;
      }
      #import-control, #change-control {
      position: absolute;
      right: 20px;
      bottom: 20px;
      }
      #import-import, #change-change { font-weight: bold; }
      .change-target { cursor: pointer; }
      .prev-selection { 
        background-color: #363634;
      }

      #solutions {
        position: relative;
        top: 0px;
        right: 0px;
        bottom: 0px;
        left: 0px;
        overflow: auto;
        padding: 5%;
        background-color:rgba(0,0,0,0.35);
      }
      #solutions:hover li {
        padding-left: 11px;
      }
      #solutions li {
        transition: background-color 0.05s ease-in-out;
        transition: padding 0.3s ease;
      }

      #solutions li:hover {
        background: rgb(60,60,60);
        padding: 20px 11px;
      }
#screenshot-upload {

  display: block;
  background-color: white;
  border: 1px solid black;
}
.uploaded-image {
  display: block;
  cursor: pointer;
  width: 100%;
      }
      .dots {
        position: fixed !important;
        bottom: 50%;
        right: 50%;
        z-index: 99999999;
        transform: scale(6);
      }
      .navbar-right .upload ul {
        width: 550px;
      }

      .uploaded-image {

      }
      body {
        background: url('/images/black_linen_v2.png');
        background-repeat: repeat;

      }
      th, label, #status, li, p {
        color: white;  
      }
      #profile-selector {
        color: black;
      }
      #screenshot-upload {
        padding: 0px;
      }
      .dz-details{
        width: 100% !important;
        height: auto !important;
      }
      .dz-message {
        transform: scale(0.5);
      }
      .dz-image-preview {
        width: 20% !important;
        cursor: pointer !important;
        display: block !important;
        float: left;
      }
      .dz-image-preview:hover {
        
      }
      .dz-details img {
        position:relative !important;
        width: 100% !important;
        height: auto !important;
      }
      .dz-filename {
        display: none !important;
      }
      .dropzone.dz-clickable * {
        cursor: pointer !important;
      }
      .list-float-left {
        width: 40%;
        display: block;
        float: left;
      }
      .list-float-right {
        width: 60%;
        display: block;
        float: left;

      }
      .navbar-fixed-bottom .navbar-collapse {
          max-height: 650px !important;
      }
      .navbar-fixed-bottom {
          z-index: 99999;
          font-size: 200%;
      }
      .upload .glyphicon {
        color: rgb(93,167,102);
        padding: 20px;

      }
      #keep-open {
        background-color: rgba(158,190,149,1);
        color: black;
border: 1px solid rgba(0,0,0,0.09);
      }
      #keep-open:hover {
        background-color: rgba(208, 224, 203, 1);
        background-image: none;
      }
      #keep-open label {
        color: black;
      }
      
      .dropdown-menu span {
        color: black;
        display: table-cell;
      }

      #bs-example-navbar-collapse-1::-webkit-scrollbar {
        width: 1em;
      }

      #bs-example-navbar-collapse-1::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
      }

      #bs-example-navbar-collapse-1::-webkit-scrollbar-thumb {
        background-color: darkgrey;
        outline: 1px solid slategrey;
      }
      @media (max-width: 991px) {
          #solutions {
            margin-top: 600px;
          }
          #keep-open {
            display: none;
          }
          .dropdown-menu span {
            color: white;
          }
      }
      .background-fade {
        width: 100%;
        height: 100%;
        display: block;
        background-color: rgba(0, 0, 0, 0.5);
        position: absolute;
        z-index: 99997;
        top: 0;
        display: none;
      }
    </style>
  </head>
  <body>
<!-- <form id="imgur_upload" action="upload.php" method="POST">
 Choose Image : <input name="img" size="35" type="file"/><br/>
 <input type="submit" name="submit" value="Upload"/>
 </form> -->

         <p id="status">...</p>
    <canvas id="path" width="380" height="316"></canvas>
    <div id="grid">
      <div id="o00" class="row1"></div>
      <div id="o01" class="row1"></div>
      <div id="o02" class="row1"></div>
      <div id="o03" class="row1"></div>
      <div id="o04" class="row1"></div>
      <div id="o05" class="row1"></div>
      <div id="o10" class="row2"></div>
      <div id="o11" class="row2"></div>
      <div id="o12" class="row2"></div>
      <div id="o13" class="row2"></div>
      <div id="o14" class="row2"></div>
      <div id="o15" class="row2"></div>
      <div id="o20" class="row3"></div>
      <div id="o21" class="row3"></div>
      <div id="o22" class="row3"></div>
      <div id="o23" class="row3"></div>
      <div id="o24" class="row3"></div>
      <div id="o25" class="row3"></div>
      <div id="o30" class="row4"></div>
      <div id="o31" class="row4"></div>
      <div id="o32" class="row4"></div>
      <div id="o33" class="row4"></div>
      <div id="o34" class="row4"></div>
      <div id="o35" class="row4"></div>
      <div id="o40" class="row5"></div>
      <div id="o41" class="row5"></div>
      <div id="o42" class="row5"></div>
      <div id="o43" class="row5"></div>
      <div id="o44" class="row5"></div>
      <div id="o45" class="row5"></div>
    </div>
    <div id="profile">
      <table>
        <tr>
          <th></th>
          <th>Normal (3+)</th>
          <th>Mass (5+)</th>
        </tr>
        <tr>
          <td class="e0" title="Fire"></td>
          <td><input id="e0-normal" value="1"/></td>
          <td><input id="e0-mass" value="3"/></td>
        </tr>
        <tr>
          <td class="e1" title="Water"></td>
          <td><input id="e1-normal" value="1"/></td>
          <td><input id="e1-mass" value="3"/></td>
        </tr>
        <tr>
          <td class="e2" title="Wood"></td>
          <td><input id="e2-normal" value="1"/></td>
          <td><input id="e2-mass" value="3"/></td>
        </tr>
        <tr>
          <td class="e3" title="Light"></td>
          <td><input id="e3-normal" value="1"/></td>
          <td><input id="e3-mass" value="3"/></td>
        </tr>
        <tr>
          <td class="e4" title="Dark"></td>
          <td><input id="e4-normal" value="1"/></td>
          <td><input id="e4-mass" value="3"/></td>
        </tr>
        <tr>
          <td class="e5" title="Heal"></td>
          <td><input id="e5-normal" value="0.3"/></td>
          <td><input id="e5-mass" value="0.3"/></td>
        </tr>
        <tr>
          <td class="e6" title="Junk"></td>
          <td><input id="e6-normal" value="0.1"/></td>
          <td><input id="e6-mass" value="0.1"/></td>
        </tr>
      </table>
      <p>
        Profile: 
        <select class="btn btn-default"  id="profile-selector">
          <option value="1,3,1,3,1,3,1,3,1,3,0.3,0.3,0.1,0.1" selected="selected">5-color team, multiple target</option>
          <option value="1,1,1,1,1,1,1,1,1,1,0.3,0.3,0.1,0.1">5-color team, single target</option>
          <option value="0.1,0.1,0.1,0.1,0.1,0.1,0.1,0.1,0.1,0.1,1,1,0.1,0.1">Recovery</option>
          <option value="0.1,0.3,0.1,0.3,0.1,0.3,0.1,0.3,0.1,0.3,1,1,0.1,0.1">Recovery, multiple target</option>
          <option value="1,3,0.1,0.1,0.1,0.1,0.1,0.1,0.1,0.1,0.3,0.3,0.1,0.1">Fire team, multiple target</option>
          <option value="1,1,0.1,0.1,0.1,0.1,0.1,0.1,0.1,0.1,0.3,0.3,0.1,0.1">Fire team, single target</option>
          <option value="0.1,0.1,1,3,0.1,0.1,0.1,0.1,0.1,0.1,0.3,0.3,0.1,0.1">Water team, multiple target</option>
          <option value="0.1,0.1,1,1,0.1,0.1,0.1,0.1,0.1,0.1,0.3,0.3,0.1,0.1">Water team, single target</option>
          <option value="0.1,0.1,0.1,0.1,1,3,0.1,0.1,0.1,0.1,0.3,0.3,0.1,0.1">Wood team, multiple target</option>
          <option value="0.1,0.1,0.1,0.1,1,1,0.1,0.1,0.1,0.1,0.3,0.3,0.1,0.1">Wood team, single target</option>
          <option value="0.1,0.1,0.1,0.1,0.1,0.1,1,3,0.1,0.1,0.3,0.3,0.1,0.1">Light team, multiple target</option>
          <option value="0.1,0.1,0.1,0.1,0.1,0.1,1,1,0.1,0.1,0.3,0.3,0.1,0.1">Light team, single target</option>
          <option value="0.1,0.1,0.1,0.1,0.1,0.1,0.1,0.1,1,3,0.3,0.3,0.1,0.1">Dark team, multiple target</option>
          <option value="0.1,0.1,0.1,0.1,0.1,0.1,0.1,0.1,1,1,0.3,0.3,0.1,0.1">Dark team, single target</option>
        </select>
      </p>
    </div>
    <div id="controls">
      <input type="checkbox" id="allow-8"/>
      <label for="allow-8">Allow 8-direction movement</label><br />
      <label for="max-length">Max path length</label>
      <input id="max-length" value="16" size="3"/><br />
      <input class="btn btn-default" type="button" value="Solve" id="solve"/>
    </div>
    <div id="extra-controls">
      <input class="btn btn-default" type="button" value="Drop matches" id="drop"/> &bull;
      <input class="btn btn-default" type="button" value="Final state" id="final"/> &bull;
      <select class="btn btn-default"  id="randomization-type">
        <option value="0,1,2">3-color</option>
        <option value="0,1,2,5">3 + Heal</option>
        <option value="0,1,2,3,4">5-color</option>
        <option value="0,1,2,3,4,5" selected="selected">5 + Heal</option>
        <option value="0,1,2,3,4,5,6">All</option>
      </select>
      <input class="btn btn-default" type="button" value="Randomize" id="randomize"/> &bull;
      <input class="btn btn-default" type="button" value="Clear" id="clear"/> &bull;
      <input class="btn btn-default" type="button" value="Import" id="import"/> &bull;
      <input class="btn btn-default" type="button" value="Change orbs" id="change"/>
    </div>
    <div id="hand"></div>
    <div id="import-popup">
      <div id="import-legend">
        <span class="e0"></span> = 0 / r<br />
        <span class="e1"></span> = 1 / b<br />
        <span class="e2"></span> = 2 / g<br />
        <span class="e3"></span> = 3 / y<br />
        <span class="e4"></span> = 4 / p<br />
        <span class="e5"></span> = 5 / h<br />
        <span class="e6"></span> = 6 / j<br />
        <span class="eX"></span> = . / x<br />
      </div>
      <textarea id="import-textarea" cols="6" rows="5" spellcheck="false"></textarea>
      <div id="import-control">
        <input type="button" value="Cancel" id="import-cancel"/>
        <input type="button" value="Import" id="import-import"/>
      </div>
    </div>
    <div id="change-popup">
      <div>
        <span class="e0"></span> &rarr; <span class="e0 change-target"></span><br />
        <span class="e1"></span> &rarr; <span class="e1 change-target"></span><br />
        <span class="e2"></span> &rarr; <span class="e2 change-target"></span><br />
        <span class="e3"></span> &rarr; <span class="e3 change-target"></span><br />
        <span class="e4"></span> &rarr; <span class="e4 change-target"></span><br />
        <span class="e5"></span> &rarr; <span class="e5 change-target"></span><br />
        <span class="e6"></span> &rarr; <span class="e6 change-target"></span><br />
        <span class="eX"></span> &rarr; <span class="eX change-target"></span>
      </div>
      <div id="change-control">
        <input type="button" value="Cancel" id="change-cancel"/>
        <input type="button" value="Change" id="change-change"/>
      </div>
    </div>
    <div class="container-fluid" style="padding: 0 5%;">
    <div class="row">
      <div class="row">
        <div class="col-md-8">
        


        </div>
        <div class="col-md-4">
          <!-- <h1>.col-md-4</h1> -->
          <div id="solutions">

            <ol></ol>
          </div>
        </div>
      </div>
     </div>
  </div>

<nav class="navbar navbar-inverse navbar-fixed-bottom" role="navigation">
<div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><span class="glyphicon glyphicon-tower"></span> Combo.Tips</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse in" id="bs-example-navbar-collapse-1">

      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown upload open">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Import from screenshot <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li class="list-float-left"><a href="#"><img class="uploaded-image" src="/images/image2.png"></a>
            
            <span class="glyphicon glyphicon-question-sign"> </span><span>Click the image to import</span>
            </li>
            <li class="list-float-right"><a href="#"><form id="screenshot-upload" action="upload.php" class="dropzone">

    </form></a></li>
            <li class="divider"></li>
            <li class="divider">
            
            </li>
            <li><a id="keep-open" href="#">
            <form role="form">
            <div class="checkbox">
              <label>
                <input type="checkbox"> Don't close this window!
              </label>
              </form>
            </div></a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<span style="position: fixed; display: block; bottom: 55px; left: 10px; font-size: 13px; color: rgba(255,255,255,0.7);">Alpha 1.2</span>
    <script src="/ext/easeljs-0.7.1.min.js"></script>
    <script src="/ext/main.js"></script>
    <script>
      var ROWS = 5;
      var COLS = 6;
      var TYPES = 7;
      var ORB_X_SEP = 64;
      var ORB_Y_SEP = 64;
      var ORB_WIDTH = 60;
      var ORB_HEIGHT = 60;
      var MULTI_ORB_BONUS = 0.25;
      var COMBO_BONUS = 0.25;
      var MAX_SOLUTIONS_COUNT = ROWS * COLS * 8 * 2;
      
      function make_rc(row, col) {
          return {row: row, col: col};
      }
      
      function make_match(type, count) {
          return {type: type, count: count};
      }
      
      function to_xy(rc) {
          var x = rc.col * ORB_X_SEP + ORB_WIDTH/2;
          var y = rc.row * ORB_Y_SEP + ORB_HEIGHT/2;
          return {x: x, y: y};
      }
      
      function copy_rc(rc) {
          return {row: rc.row, col: rc.col};
      }
      
      function equals_xy(a, b) {
          return a.x == b.x && a.y == b.y;
      }
      
      function equals_rc(a, b) {
          return a.row == b.row && a.col == b.col;
      }
      
      function create_empty_board() {
          var result = new Array(ROWS);
          for (var i = 0; i < ROWS; ++ i) {
              result[i] = new Array(COLS);
          }
          return result;
      }
      
      function get_board() {
          var result = create_empty_board();
          $('#grid > div').each(function() {
              var row = this.id.charAt(1);
              var col = this.id.charAt(2);
              var type = get_type(this);
              result[row][col] = type;
          });
          return result;
      }
      
      function ensure_no_X(board) {
          for (var i = 0; i < ROWS; ++ i) {
              for (var j = 0; j < COLS; ++ j) {
                  if (board[i][j] == 'X') {
                      throw 'Cannot have "?" orbs when solving.';
                  }
              }
          }
      }
      
      function copy_board(board) {
          return board.map(function(a) { return a.slice(); });
      }
      
      function get_type(elem) {
          return elem.className.match(/e([\dX])/)[1];
      }
      
      function advance_type(type, dt) {
          if (type == 'X') {
              return '0';
          } else {
              var new_type = dt + +type;
              if (new_type < 0) {
                  new_type += TYPES;
              } else if (new_type >= TYPES) {
                  new_type -= TYPES;
              }
              return new_type;
          }
      }
      
      function get_weights() {
          var weights = new Array(TYPES);
          for (var i = 0; i < TYPES; ++ i) {
              weights[i] = {
                  normal: +$('#e' + i + '-normal').val(),
                  mass: +$('#e' + i + '-mass').val(),
              };
          }
          return weights;
      }
      
      function find_matches(board) {
          var match_board = create_empty_board();
      
          // 1. filter all 3+ consecutives.
          //  (a) horizontals
          for (var i = 0; i < ROWS; ++ i) {
              var prev_1_orb = 'X';
              var prev_2_orb = 'X';
              for (var j = 0; j < COLS; ++ j) {
                  var cur_orb = board[i][j];
                  if (prev_1_orb == prev_2_orb && prev_2_orb == cur_orb && cur_orb != 'X') {
                      match_board[i][j] = cur_orb;
                      match_board[i][j-1] = cur_orb;
                      match_board[i][j-2] = cur_orb;
                  }
                  prev_1_orb = prev_2_orb;
                  prev_2_orb = cur_orb;
              }
          }
          //  (b) verticals
          for (var j = 0; j < COLS; ++ j) {
              var prev_1_orb = 'X';
              var prev_2_orb = 'X';
              for (var i = 0; i < ROWS; ++ i) {
                  var cur_orb = board[i][j];
                  if (prev_1_orb == prev_2_orb && prev_2_orb == cur_orb && cur_orb != 'X') {
                      match_board[i][j] = cur_orb;
                      match_board[i-1][j] = cur_orb;
                      match_board[i-2][j] = cur_orb;
                  }
                  prev_1_orb = prev_2_orb;
                  prev_2_orb = cur_orb;
              }
          }
      
          var scratch_board = copy_board(match_board);
      
          // 2. enumerate the matches by flood-fill.
          var matches = [];
          for (var i = 0; i < ROWS; ++ i) {
              for (var j = 0; j < COLS; ++ j) {
                  var cur_orb = scratch_board[i][j];
                  if (typeof(cur_orb) == 'undefined') { continue; }
                  var stack = [make_rc(i, j)];
                  var count = 0;
                  while (stack.length) {
                      var n = stack.pop();
                      if (scratch_board[n.row][n.col] != cur_orb) { continue; }
                      ++ count;
                      scratch_board[n.row][n.col] = undefined;
                      if (n.row > 0) { stack.push(make_rc(n.row-1, n.col)); }
                      if (n.row < ROWS-1) { stack.push(make_rc(n.row+1, n.col)); }
                      if (n.col > 0) { stack.push(make_rc(n.row, n.col-1)); }
                      if (n.col < COLS-1) { stack.push(make_rc(n.row, n.col+1)); }
                  }
                  matches.push(make_match(cur_orb, count));
              }
          }
      
          return {matches: matches, board: match_board};
      }
      
      function equals_matches(a, b) {
          if (a.length != b.length) {
              return false;
          }
          return a.every(function(am, i) {
              var bm = b[i];
              return am.type == bm.type && am.count == bm.count;
          });
      }
      
      function compute_weight(matches, weights) {
          var total_weight = 0;
          matches.forEach(function(m) {
              var base_weight = weights[m.type][m.count >= 5 ? 'mass' : 'normal'];
              var multi_orb_bonus = (m.count - 3) * MULTI_ORB_BONUS + 1;
              total_weight += multi_orb_bonus * base_weight;
          });
          var combo_bonus = (matches.length - 1) * COMBO_BONUS + 1;
          return total_weight * combo_bonus;
      }
      
      function show_element_type(jqel, type) {
          jqel.removeClass('eX');
          for (var i = 0; i < TYPES; ++ i) {
              jqel.removeClass('e' + i);
          }
          jqel.addClass('e' + type);
      }
      
      function show_board(board) {
          for (var i = 0; i < ROWS; ++ i) {
              for (var j = 0; j < COLS; ++ j) {
                  var type = board[i][j];
                  if (typeof(type) == 'undefined') {
                      type = 'X';
                  }
                  show_element_type($('#o' + i + '' + j), type);
              }
          }
      }
      
      function in_place_remove_matches(board, match_board) {
          for (var i = 0; i < ROWS; ++ i) {
              for (var j = 0; j < COLS; ++ j) {
                  if (typeof(match_board[i][j]) != 'undefined') {
                      board[i][j] = 'X';
                  }
              }
          }
          return board;
      }
      
      function in_place_drop_empty_spaces(board) {
          for (var j = 0; j < COLS; ++ j) {
              var dest_i = ROWS-1;
              for (var src_i = ROWS-1; src_i >= 0; -- src_i) {
                  if (board[src_i][j] != 'X') {
                      board[dest_i][j] = board[src_i][j];
                      -- dest_i;
                  }
              }
              for (; dest_i >= 0; -- dest_i) {
                  board[dest_i][j] = 'X';
              }
          }
          return board;
      }
      
      function can_move_orb(rc, dir) {
          switch (dir) {
              case 0: return                    rc.col < COLS-1;
              case 1: return rc.row < ROWS-1 && rc.col < COLS-1;
              case 2: return rc.row < ROWS-1;
              case 3: return rc.row < ROWS-1 && rc.col > 0;
              case 4: return                    rc.col > 0;
              case 5: return rc.row > 0      && rc.col > 0;
              case 6: return rc.row > 0;
              case 7: return rc.row > 0      && rc.col < COLS-1;
          }
          return false;
      }
      
      function in_place_move_rc(rc, dir) {
          switch (dir) {
              case 0:              rc.col += 1; break;
              case 1: rc.row += 1; rc.col += 1; break;
              case 2: rc.row += 1;              break;
              case 3: rc.row += 1; rc.col -= 1; break;
              case 4:              rc.col -= 1; break;
              case 5: rc.row -= 1; rc.col -= 1; break;
              case 6: rc.row -= 1;              break;
              case 7: rc.row -= 1; rc.col += 1; break;
          }
      }
      
      function in_place_swap_orb(board, rc, dir) {
          var old_rc = copy_rc(rc);
          in_place_move_rc(rc, dir);
          var orig_type = board[old_rc.row][old_rc.col];
          board[old_rc.row][old_rc.col] = board[rc.row][rc.col];
          board[rc.row][rc.col] = orig_type;
          return {board: board, rc: rc};
      }
      
      function copy_solution_with_cursor(solution, i, j, init_cursor) {
          return {board: copy_board(solution.board),
                  cursor: make_rc(i, j),
                  init_cursor: init_cursor || make_rc(i, j),
                  path: solution.path.slice(),
                  is_done: solution.is_done,
                  weight: 0,
                  matches: []};
      }
      
      function copy_solution(solution) {
          return copy_solution_with_cursor(solution,
                                           solution.cursor.row, solution.cursor.col,
                                           solution.init_cursor);
      }
      
      function make_solution(board) {
          return {board: copy_board(board),
                  cursor: make_rc(0, 0),
                  init_cursor: make_rc(0, 0),
                  path: [],
                  is_done: false,
                  weight: 0,
                  matches: []};
      }
      
      function in_place_evaluate_solution(solution, weights) {
          var current_board = copy_board(solution.board);
          var all_matches = [];
          while (true) {
              var matches = find_matches(current_board);
              if (matches.matches.length == 0) {
                  break;
              }
              in_place_remove_matches(current_board, matches.board);
              in_place_drop_empty_spaces(current_board);
              all_matches = all_matches.concat(matches.matches);
          }
          solution.weight = compute_weight(all_matches, weights);
          solution.matches = all_matches;
          return current_board;
      }
      
      function can_move_orb_in_solution(solution, dir) {
          // Don't allow going back directly. It's pointless.
          if (solution.path[solution.path.length-1] == (dir + 4) % 8) {
              return false;
          }
          return can_move_orb(solution.cursor, dir);
      }
      
      function in_place_swap_orb_in_solution(solution, dir) {
          var res = in_place_swap_orb(solution.board, solution.cursor, dir);
          solution.cursor = res.rc;
          solution.path.push(dir);
      }
      
      function get_max_path_length() {
          return +$('#max-length').val();
      }
      
      function is_8_dir_movement_supported() {
          return $('#allow-8')[0].checked;
      }
      
      function evolve_solutions(solutions, weights, dir_step) {
          var new_solutions = [];
          solutions.forEach(function(s) {
              if (s.is_done) {
                  return;
              }
              for (var dir = 0; dir < 8; dir += dir_step) {
                  if (!can_move_orb_in_solution(s, dir)) {
                      continue;
                  }
                  var solution = copy_solution(s);
                  in_place_swap_orb_in_solution(solution, dir);
                  in_place_evaluate_solution(solution, weights);
                  new_solutions.push(solution);
              }
              s.is_done = true;
          });
          solutions = solutions.concat(new_solutions);
          solutions.sort(function(a, b) { return b.weight - a.weight; });
          return solutions.slice(0, MAX_SOLUTIONS_COUNT);
      }
      
      function solve_board(board, step_callback, finish_callback) {
          var solutions = new Array(ROWS * COLS);
          var weights = get_weights();
      
          var seed_solution = make_solution(board);
          in_place_evaluate_solution(seed_solution, weights);
      
          for (var i = 0, s = 0; i < ROWS; ++ i) {
              for (var j = 0; j < COLS; ++ j, ++ s) {
                  solutions[s] = copy_solution_with_cursor(seed_solution, i, j);
              }
          }
      
          var solve_state = {
              step_callback: step_callback,
              finish_callback: finish_callback,
              max_length: get_max_path_length(),
              dir_step: is_8_dir_movement_supported() ? 1 : 2,
              p: 0,
              solutions: solutions,
              weights: weights,
          };
      
          solve_board_step(solve_state);
      }
      
      function solve_board_step(solve_state) {
          if (solve_state.p >= solve_state.max_length) {
              solve_state.finish_callback(solve_state.solutions);
              return;
          }
      
          ++ solve_state.p;
          solve_state.solutions = evolve_solutions(solve_state.solutions,
                                                   solve_state.weights,
                                                   solve_state.dir_step);
          solve_state.step_callback(solve_state.p, solve_state.max_length);
      
          setTimeout(function() { solve_board_step(solve_state); }, 0);
      }
      
      function add_solution_as_li(html_array, solution) {
          html_array.push('<li>W=');
          html_array.push(solution.weight.toFixed(2));
          html_array.push(', L=');
          html_array.push(solution.path.length);
          var sorted_matches = solution.matches.slice();
          sorted_matches.sort(function(a, b) {
              if (a.count != b.count) {
                  return b.count - a.count;
              } else if (a.type > b.type) {
                  return 1;
              } else if (a.type < b.type) {
                  return -1;
              } else {
                  return 0;
              }
          });
          sorted_matches.forEach(function(match, i) {
              html_array.push(', <span class="e');
              html_array.push(match.type);
              html_array.push('"></span> &times; ');
              html_array.push(match.count);
          });
          html_array.push('</li>');
      }
      
      function simplify_path(xys) {
          // 1. Remove intermediate points.
          var simplified_xys = [xys[0]];
          var xys_length_1 = xys.length - 1;
          for (var i = 1; i < xys_length_1; ++ i) {
              var dx0 = xys[i].x - xys[i-1].x;
              var dx1 = xys[i+1].x - xys[i].x;
              if (dx0 == dx1) {
                  var dy0 = xys[i].y - xys[i-1].y;
                  var dy1 = xys[i+1].y - xys[i].y;
                  if (dy0 == dy1) {
                      continue;
                  }
              }
              simplified_xys.push(xys[i]);
          }
          simplified_xys.push(xys[xys_length_1]);
      
          return simplified_xys;
      }
      
      function simplify_solutions(solutions) {
          var simplified_solutions = [];
          solutions.forEach(function(solution) {
              for (var s = simplified_solutions.length-1; s >= 0; -- s) {
                  var simplified_solution = simplified_solutions[s];
                  if (!equals_rc(simplified_solution.init_cursor, solution.init_cursor)) {
                      continue;
                  }
                  if (!equals_matches(simplified_solution.matches, solution.matches)) {
                      continue;
                  }
                  return;
              }
              simplified_solutions.push(solution);
          });
          return simplified_solutions;
      }
      
      function draw_line_to(canvas, px, py, x, y) {
          var mx = (px*2 + x) / 3;
          var my = (py*2 + y) / 3;
          canvas.lineTo(mx, my);
          var dx = x - px;
          var dy = y - py;
          var dr = Math.sqrt(dx*dx + dy*dy) / 3;
          dx /= dr;
          dy /= dr;
          canvas.lineTo(mx - (dx+dy), my + (dx-dy));
          canvas.lineTo(mx - (dx-dy), my - (dx+dy));
          canvas.lineTo(mx, my);
          canvas.lineTo(x, y);
      }
      
      function draw_path(init_rc, path) {
          var canvas = clear_canvas();
      
          var rc = copy_rc(init_rc);
          var xys = [to_xy(rc)];
          path.forEach(function(p) {
              in_place_move_rc(rc, p);
              xys.push(to_xy(rc));
          });
      
          xys = simplify_path(xys);
      
          canvas.lineWidth = 4;
          canvas.strokeStyle = 'rgba(0, 0, 0, 0.75)';
          canvas.beginPath();
          for (var i = 0; i < xys.length; ++ i) {
              var xy = xys[i];
              if (i == 0) {
                  canvas.moveTo(xy.x, xy.y);
              } else {
                  var prev_xy = xys[i-1];
                  draw_line_to(canvas, prev_xy.x, prev_xy.y, xy.x, xy.y);
              }
          }
          canvas.stroke();
      
          var init_xy = xys[0];
          var final_xy = xys[xys.length-1];
      
          canvas.lineWidth = 2;
          canvas.fillStyle = 'red';
          canvas.strokeStyle = 'black';
          canvas.beginPath();
          canvas.rect(init_xy.x-5, init_xy.y-5, 10, 10);
          canvas.fill();
          canvas.stroke();
      
          canvas.fillStyle = 'lime';
          canvas.beginPath();
          canvas.rect(final_xy.x-5, final_xy.y-5, 10, 10);
          canvas.fill();
          canvas.stroke();
      
          return xys;
      }
      
      function clear_canvas() {
          var canvas_elem = $('#path')[0];
          var canvas = canvas_elem.getContext('2d');
          canvas.clearRect(0, 0, canvas_elem.width, canvas_elem.height);
          $('#hand').hide();
          return canvas;
      }
      
      var global_board = create_empty_board();
      var global_solutions = [];
      var global_index = 0;
      
      $(document).ready(function() {

          $('#grid > div').each(function(index) {

              $(this).addClass('eX');
      	
              // ALEX - We will import the orbs within this each function
          });
      
          $('#grid > div, .change-target').mousedown(function(e) {
              var type = get_type(this);
              var target_type;
              switch (e.which) {
                  case 1: target_type = advance_type(type, 1); break;     // left
                  case 3: target_type = advance_type(type, -1); break;    // right
                  case 2: target_type = 'X'; break;                       // middle
                  default: break;
              }
              show_element_type($(this), target_type);
              clear_canvas();
          });
      
          $('#hand, #import-popup, #change-popup').hide();
      
          $('#profile-selector').change(function() {
              var values = this.value.split(/,/);
              for (var i = 0; i < TYPES; ++ i) {
                  $('#e' + i + '-normal').val(values[2*i]);
                  $('#e' + i + '-mass').val(values[2*i+1]);
              }
          });
      
          $('#solve').click(function() {
              $('#grid > div').each(function(){ $(this).removeClass('border-flash'); });
              var solver_button = this;
              var board = get_board();
              global_board = board;
              solver_button.disabled = true;
              solve_board(board, function(p, max_p) {
                  $('#status').text('Solving (' + p + '/' + max_p + ')...');
              }, function(solutions) {
                  var html_array = [];
                  solutions = simplify_solutions(solutions);
                  global_solutions = solutions;
                  solutions.forEach(function(solution) {
                      add_solution_as_li(html_array, solution, board);
                  });
                  $('#solutions > ol').html(html_array.join(''));
                  solver_button.disabled = false;
              });
              //$(document).initImageAnalysis();
          });
      
          $('#solutions').on('click', 'li', function(e) {
              show_board(global_board);
              global_index = $(this).index();
              var solution = global_solutions[global_index];
              var path = draw_path(solution.init_cursor, solution.path);
              var hand_elem = $('#hand');
              hand_elem.stop(/*clearQueue*/true).show();
              path.forEach(function(xy, i) {
                  var left = xy.x + 13;
                  var top = xy.y + 13;
                  hand_elem[i == 0 ? 'offset' : 'animate']({left: left, top: top});
              });
              $('#solutions li.prev-selection').removeClass('prev-selection');
              $(this).addClass('prev-selection');
          });
      
          $('#randomize').click(function() {
              var types = $('#randomization-type').val().split(/,/);
              $('#grid > div').each(function() {
                  var index = Math.floor(Math.random() * types.length);
                  show_element_type($(this), types[index]);
              });
              clear_canvas();
          });
      
          $('#clear').click(function() {
              $('#grid > div').each(function() { show_element_type($(this), 'X'); });
              clear_canvas();
          });
      
          $('#drop').click(function() {
              var solution = global_solutions[global_index];
              if (!solution) {
                  return;
              }
              var board = in_place_evaluate_solution(solution, get_weights());
              show_board(board);
              clear_canvas();
          });
      
          $('#final').click(function() {
              var solution = global_solutions[global_index];
              if (solution) {
                  show_board(solution.board);
              }
          });
      
          $('#import').click(function() {
              var board = get_board();
              var type_chars = 'rbgyphj';
              var content = board.map(function(row) { return row.join(''); }).join('\n')
                  .replace(/X/g, '.')
                  .replace(/(\d)/g, function(s) { return type_chars.charAt(s); });
              $('#import-textarea').val(content);
              $('#import-popup').show();
          });
      
          $('#change').click(function() { $('#change-popup').show(); });
          $('#import-cancel').click(function() { $('#import-popup').hide(); });
          $('#change-cancel').click(function() { $('#change-popup').hide(); });
      
          $('#import-import').click(function() {
              var board_raw = $('#import-textarea').val();
              var board_joined = board_raw
                      .replace(/r/gi, '0')
                      .replace(/b/gi, '1')
                      .replace(/g/gi, '2')
                      .replace(/y/gi, '3')
                      .replace(/p/gi, '4')
                      .replace(/h/gi, '5')
                      .replace(/j/gi, '6')
                      .replace(/\s/g, '')
                      .replace(/[^0-6]/g, 'X');
              if (board_joined.length != ROWS * COLS) {
                  alert('Wrong number of orbs!');
                  return;
              }
              var board = board_joined.match(/.{6}/g).map(function(s) { return s.split(''); });
              show_board(board);
              clear_canvas();
              $('#import-popup').hide();
          });
      
          $('#change-change').click(function() {
              var change_targets = $('.change-target').map(function() {
                  return get_type(this);
              });
              var board = get_board();
              for (var i = 0; i < ROWS; ++ i) {
                  for (var j = 0; j < COLS; ++ j) {
                      var type = board[i][j];
                      if (type == 'X') {
                          type = change_targets[change_targets.length-1];
                      } else {
                          type = change_targets[type];
                      }
                      board[i][j] = type;
                  }
              }
              show_board(board);
              clear_canvas();
              $('#change-popup').hide();
          });
      });
      
      
    </script>
  </body>
</html>
<!-- AGPLv3
  pndopt - Puzzle & Dragons Optimizer
  Copyright (C) 2013  kennytm
  
  This program is free software: you can redistribute it and/or modify
  it under the terms of the GNU Affero General Public License as
  published by the Free Software Foundation, either version 3 of the
  License, or (at your option) any later version.
  
  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU Affero General Public License for more details.
  
  You should have received a copy of the GNU Affero General Public License
  along with this program.  If not, see <http://www.gnu.org/licenses/>.
  
  -->
