<nav class="portfolio-nav grey darken-2">
<ul>
  <li>
  	<a class="dropdown-button" href="#" data-activates="inter-portfolio-nav">
  		<i class="material-icons side-nav-button">menu</i>
  	</a>
  </li>
  <li><a href="#overview-tab">Overview</a></li>
  <li><a href="#all-stocks-tab">All Stocks</a></li>
  <li><a href="#analysis-tab">Analysis</a></li>
  <li><a href="#comparison-tab">Comparison</a></li>
  <li><a href="#trades-tab">Trades</a></li>
 </ul>
</nav>
<ul id="inter-portfolio-nav" class="dropdown-content">
  <?php $all_portfolios = Spark\locals()['all_portfolios'] ?>
  <?php foreach($all_portfolios as $portfolio): ?>
    <?php $name = strlen($portfolio->name) > 20 ? substr($portfolio->name,0,20)."..." : $portfolio->name; ?>
    <li><a href="/portfolios/<?= $portfolio->id ?>"><?= $name ?> </a></li>
  <?php endforeach ; ?>

  <?php if (count($all_portfolios) < 5) : ?>
    <li><a href="/portfolios/new"><span class='badge'>+</span> New Portfolio</a></li>
  <?php endif ; ?>
</ul>
