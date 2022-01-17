<!DOCTYPE html>
<html lang="en">
<head>

  <!-- Basic Page Needs
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta charset="utf-8">
  <title>Conway's Game of Life: Mathematics and Construction</title>
  <meta name="description" content="A textbook for mathematical aspects of Conway's Game of Life and methods of pattern construction.">
  <meta name="author" content="Nathaniel Johnston and Dave Greene">

  <!-- Mobile Specific Metas
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- FONT
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link href='//fonts.googleapis.com/css?family=Raleway:400,300,600' rel='stylesheet' type='text/css'>

  <!-- CSS
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/skeleton.css">
  <link rel="stylesheet" href="css/custom.css">

  <!-- Scripts
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js"></script>
  <link rel="stylesheet" href="css/github-prettify-theme.css">
  <script src="js/site.js"></script>

<link rel="shortcut icon" type="image/png" href="https://conwaylife.com/book/favicon.png" />

<style>
.anchor{
  display: block;
  height: 60px; /*same height as header*/
  margin-top: -60px; /*same height as header*/
  visibility: hidden;
}
</style>

</head>
<body class="code-snippets-visible">

    <div class="container">
      <div class="row" style="padding-top:4rem;padding-bottom:1rem;">
        <div style="width:158px;" class="bookimgdiv">
          <img src="images/logo.png" style="width:158px;height:157px;" class="bookimg">
        </div>
        <div style="overflow: hidden;">
          <h1 style="font-weight:bold;margin-bottom:0px;">Conway's Game of Life</h1>
          <h3 style="margin-top:0px;">Mathematics and Construction</h3>
          <a class="button button-primary" href="#download_pdf">Download the Book</a>
        </div>
      </div>

  <!-- Primary Page Layout
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->

    <div class="navbar-spacer"></div>
    <nav class="navbar">
      <div class="container">
        <ul class="navbar-list">
          <li class="navbar-item">&nbsp;<a class="navbar-link" href="#about">About the Book</a></li>
          <li class="navbar-item"><a class="navbar-link" href="#download_pdf">Download the Book</a></li>
          <li class="navbar-item"><a class="navbar-link" href="#rle_files">Pattern Files</a></li>
          <li class="navbar-item"><a class="navbar-link" href="#cite">Specifications</a></li>
        </ul>
      </div>
    </nav>




    <div class="docs-section" style="margin-bottom:0px;padding-bottom:0px;">
      <h6 class="docs-header" style="color:red;">Print version coming soon!<br /><font color="black">The PDF version of the book is available below.</font></h6>
    </div>



    <div class="docs-section">
      <h6 class="docs-header">About the Book</h6>
      <p>This book provides an introduction to <a href="http://www.conwaylife.com/wiki/Conway%27s_Game_of_Life">Conway's Game of Life</a>, the interesting mathematics behind it, and the methods used to construct many of its most interesting patterns. Lots of small "building block"-style patterns (especially in the first four or so chapters of this book) were found via brute-force or other computer searches, and the book does not go into the details of how these searches were implemented. However, from that point on it tries to guide the reader through the thought processes and ideas that are needed to combine those patterns into more interesting composite ones.</p>
      <p>While the book largely follows the history of the Game of Life, that is <em>not</em> its primary purpose. Rather, it is a by-product of the fact that most recently discovered patterns build upon patterns and techniques that were developed earlier. The goal of this book is to demystify the Game of Life by breaking down the complex patterns that have been developed in it into bite-size chunks that can be understood individually.</p>
    </div>


<span class="anchor" id="download_pdf"></span>
    <div class="docs-section">
      <h6 class="docs-header">Download the Book</h6>
      <p>Whether you are using it for self-study or a course, the textbook can be downloaded as a PDF file free of charge. We recommend that you view the PDF in a stand-alone PDF reader like <a href="https://get.adobe.com/reader/">Adobe Acrobat</a> (which is also free), <em>not</em> your in-browser PDF viewer, so that you can click on pattern images to view their <a href="http://www.conwaylife.com/wiki/RLE">RLE encodings</a> (which you can then copy and paste into Life software like <a href="http://golly.sourceforge.net/">Golly</a>).</p>
      <center>
        <a class="button button-primary" href="conway_life_book.pdf" style="padding-left:15px;"><img src="images/pdf.png" style="vertical-align:middle;padding-bottom:3px;padding-right:15px;">Book in PDF Format (91.23 Mb)</a>
      </center>
    </div>


<span class="anchor" id="rle_files"></span>
    <div class="docs-section">
      <h6 class="docs-header">Pattern Files</h6>
      <p>Pattern files for all patterns that are displayed as figures in the book are provided here. You can view and manipulate these patterns right in your web browser, or you can copy these code files into Game of Life software like <a href="http://golly.sourceforge.net/">Golly</a>.</p>
      <center><b><a href="patterns/all.zip">All pattern files, except for Chapter 12, in a .zip archive file (8.91 Mb)</a></b></center>
      <ul style="margin-top:12px;">
        <li><a href="/book/early_life">Chapter 1: Early Life</a></li>
        <li><a href="/book/still_lifes">Chapter 2: Still Lifes</a></li>
        <li><a href="/book/oscillators">Chapter 3: Oscillators</a></li>
        <li><a href="/book/spaceships">Chapter 4: Spaceships and Moving Objects</a></li>
        <li><a href="/book/glider_synthesis">Chapter 5: Glider Synthesis</a></li>
        <li><a href="/book/periodic_circuitry">Chapter 6: Periodic Circuitry</a></li>
        <li><a href="/book/stationary_circuitry">Chapter 7: Stable Circuitry</a></li>
        <li><a href="/book/glider_guns">Chapter 8: Guns and Glider Streams</a></li>
        <li><a href="/book/universal_computation">Chapter 9: Universal Computation</a></li>
        <li><a href="/book/self_support_spaceships">Chapter 10: Self-Supporting Spaceships</a></li>
        <li><a href="/book/universal_construction">Chapter 11: Universal Construction</a></li>
        <li><a href="/book/0e0p">Chapter 12: The 0E0P Metacell</a></li>
      </ul>
    </div>


<span class="anchor" id="cite"></span>
    <div class="docs-section">
      <h6 class="docs-header">Bibliographic Information and Specifications</h6>
      <ul>
        <li><b>Authors:</b> <a href="http://njohnston.ca">Nathaniel Johnston</a> and Dave Greene</li>
        <li><b>Publisher:</b> Lulu.com (self-published)</li>
        <li><b>Publication year:</b> 2022</li>
        <li><b>ISBN:</b> 978-1-794-81696-1</li>
        <li><b>Pages:</b> 492</li>
        <li><b>Dimensions:</b> US letter (8.5 &times; 11 in)</li>
        <li><b>Physical book:</b> Hardcover, color printing, roughly the size and weight of a ream of US letter paper</li>
      </ul>
    </div>
  </div>

<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>