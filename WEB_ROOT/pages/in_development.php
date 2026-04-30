        <?php
        $undeveloped = isset($_GET['undevelopedname']) ? trim($_GET['undevelopedname']) : ''; # gets the name of the undeveloped page or category from the query parameter, e.g. 'ForSale', 'Info_Help', 'BestOf_Sellers', etc.
        function pretty_label($s) {
          $s = preg_replace('/^(BestOf|Info|Category|Evt|News|Help|News|Evt|Help|Info)_/i', '', $s);
          $s = str_replace(array('_', '-'), ' ', $s);
          $s = preg_replace('/([a-z0-9])([A-Z])/', '$1 $2', $s); // split CamelCase like StaffPicks -> Staff Picks (https://stackoverflow.com/questions/18379254/regex-to-split-camel-case)
          return trim(ucwords($s));
        } # makes the label at the top look nicer by removing prefixes, splitting CamelCase, and converting to title case

        $heading = 'Project status';
        $notice = '';
        if ($undeveloped !== '') {
            if (stripos($undeveloped, 'BestOf_') === 0) {
                $title = pretty_label($undeveloped);
                $heading = "Best of: $title";
                $notice = "This 'Best of' page is a curated list (e.g. staff picks or top sellers). The curated/aggregation view is not implemented in this prototype — it would aggregate selected ads and display featured cards, sorting and pagination.";
            } elseif (stripos($undeveloped, 'Info_') === 0) {
                $title = pretty_label($undeveloped);
                $heading = "$title";
                $notice = "This informational page is not yet implemented. It will contain static guidance or policy content (help, privacy, terms, FAQs) relevant to the site.";
            } elseif (preg_match('/^(Evt_|News_|Help_)/i', $undeveloped)) {
                $title = pretty_label($undeveloped);
                $heading = "$title";
                $notice = "This content page (events/news/help) is not implemented. It would show event details or local news items and links to related listings.";
            } else {
                // assume category or filtering page
                $title = pretty_label($undeveloped);
                $heading = "Category: $title";
                $notice = "This category filtering page is not implemented in the prototype. In a full site this page would show listings filtered to the '$title' category, with sort, pagination and filter controls (price, location, date).";
            }
        }
        ?>

        <div class="content-section">
          <div class="section-header">
            <h2><?php echo htmlspecialchars($heading, ENT_QUOTES); ?></h2>
          </div>

          <?php if ($notice !== ''): ?>
            <p><?php echo htmlspecialchars($notice, ENT_QUOTES); ?></p>
            <hr>
            <?php endif; ?>
            <h3>Implemented (what works)</h3>
            <ul style="margin-left:40px">
              <li>Homepage with prominent search form and category grid.</li>
              <li>Search results page with filters and card-based listing layout.</li>
              <li>Post-ad form (client-side validation and file input; server endpoint is a demo/stub).</li>
              <li>Open-ad page showing listing details and sample messaging UI.</li>
              <li>Semantic HTML landmarks, ARIA attributes for key controls, visible focus styles for keyboard users.</li>
              <li>Responsive CSS (mobile-first) using Grid and Flexbox; basic soft-contrast/dark-friendly styles available in CSS.</li>
            </ul>

            <h3>Known limitations (what's intentionally incomplete)</h3>
            <ul style="margin-left:40px">
              <li>No user accounts or authentication — account flows are out of scope for this prototype.</li>
              <li>Server-side persistence (database) is not implemented; <code>api/</code> endpoints return demo JSON files located in <code>WEB_ROOT/files/posts/</code>.</li>
              <li>Messaging is a UI-only demonstration and does not send/receive real messages.</li>
              <li>Some internal links point to <code>/?page=in_development</code> as placeholders for future pages.</li>
            </ul>

            <h3>Testing this prototype locally</h3>
            <p>To preview the site locally use PHP's built-in server from the project root:</p>

            <pre><code>php -S localhost:8080 -t WEB_ROOT</code></pre>

            <p>Then open <a href="http://localhost:8080">http://localhost:8080</a> in your browser. Use browser devtools to emulate mobile viewports for responsive testing. Sample data files are in <code>WEB_ROOT/files/posts/</code>.</p>

            <h3>How you can help / contribute</h3>
            <ul style="margin-left:40px">
              <li>Report visual bugs or accessibility issues by emailing <a href="mailto:ky25aaa@herts.ac.uk">ky25aaa@herts.ac.uk</a>.</li>
              <li>To contribute code, fork the GitHub repository, make changes on a feature branch, and open a pull request. Please include concise commit messages describing each change.</li>
              <li>If you add server-side features, document any new dependencies and update the README with run steps.</li>
            </ul>

            <h3>Credits</h3>
            <p>Project by Kai Young, Will Cooper and Daniel Zhang for the DUX module. For questions or test requests contact <a href="mailto:ky25aaa@herts.ac.uk">ky25aaa@herts.ac.uk</a>.</p>

            <p style="font-size:0.9em; color:#666;">Note: this repository and the deployed prototype are for educational purposes only and are not intended to collect or process real user data.</p>

        </div>
