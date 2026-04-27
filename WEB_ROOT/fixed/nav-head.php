  <header role="banner" aria-label="Site header">
    <div class="header-left">
      <h1>craiglist</h1>
      <h3>London UK</h3>
    </div>
    <div class="header-right">
        <button onclick="window.location.href='/?page=post_ad'" class="btn btn-primary" aria-label="Post to classifieds">post to classifieds</button>
        <button class="btn btn-secondary" aria-label="My account">my account</button>
    </div>
  </header>

    <!-- NAV -->
      <nav role="navigation" aria-label="Primary navigation">
        <form action="search.php" method="GET" role="search" aria-label="Site search">
            <input type="search" name="q" placeholder="search classifieds..." aria-label="Search classifieds">
            <button type="submit" class="btn btn-primary" aria-label="Search">
              Go
              
            </button>
        </form>
        <a href="/?page=Home">home</a>
        <a href="/?page=local_ads">local ads</a>
        <a href="/?page=in_development&undevelopedname=ForSale">for sale</a>
        <a href="/?page=in_development&undevelopedname=Housing">housing</a>
        <a href="/?page=in_development&undevelopedname=Jobs">jobs</a>
        <a href="/?page=in_development&undevelopedname=Services">services</a>
        <a href="/?page=in_development&undevelopedname=Help">help</a>
      </nav>

<script>
    document.querySelector('nav form').addEventListener('submit', function(event) {
        event.preventDefault();
        const query = this.querySelector('input[name="q"]').value;
        window.location.href = `?page=search&q=${encodeURIComponent(query)}`;
    });
</script>

