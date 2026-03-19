  <header>
    <div class="header-left">
      <h1>craiglist</h1>
      <h3>London UK</h3>
    </div>
    <div class="header-right">
      <button onclick="window.location.href='/?page=post_ad'" class="btn btn-primary">post to classifieds</button>
      <button class="btn btn-secondary">my account</button>
    </div>
  </header>

    <!-- NAV -->
    <nav>
      <form action="search.php" method="GET">
        <input type="search" name="q" placeholder="search classifieds...">
        <button type="submit" class="btn btn-primary">go</button>
      </form>
      <a href="/?page=Home">home</a>
      <a href="#">community</a>
      <a href="ads.html">for sale</a>
      <a href="#">housing</a>
      <a href="#">jobs</a>
      <a href="#">services</a>
      <a href="#">help</a>
    </nav>

<script>
    document.querySelector('nav form').addEventListener('submit', function(event) {
        event.preventDefault();
        const query = this.querySelector('input[name="q"]').value;
        window.location.href = `index.php?page=search&q=${encodeURIComponent(query)}`;
    });
</script>

