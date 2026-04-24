        <div class="content-section">
          <div class="section-header">
            <h2>Project status</h2>
          </div>

          <p>This website is a compact educational prototype created for the DUX coursework. It was developed over a short period (a few weeks) to demonstrate the principles of accessible, responsive front-end design rather than to provide a fully-featured, production-ready classifieds platform.</p>

          <h3>Overview</h3>
          <p>The prototype implements the visual and interaction patterns from our wireframes and focuses on clarity, accessibility, and responsiveness. Where server-side functionality or persistent storage would normally be required, simple stubs or static/demo data are used so the front-end behaviour is testable during assessment.</p>

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
            <li>No production user accounts or authentication — account flows are out of scope for this prototype.</li>
            <li>Server-side persistence (database) is not implemented; `api/` endpoints return demo JSON files located in `WEB_ROOT/files/posts/`.</li>
            <li>Messaging is a UI-only demonstration and does not send/receive real messages.</li>
            <li>Some internal links point to `/?page=in_development` as placeholders for future pages.</li>
            <li>Map integration is not functional; comments indicate where these would be integrated.</li>
          </ul>

          <h3>Testing this prototype locally</h3>
          <p>To preview the site locally use PHP's built-in server from the project root:</p>

          <pre><code>php -S localhost:8080 -t WEB_ROOT</code></pre>

          <p>Then open <a href="http://localhost:8080">http://localhost:8080</a> in your browser. Use browser devtools to emulate mobile viewports for responsive testing. Sample data files are in `WEB_ROOT/files/posts/`.</p>

          <h3>How you can help / contribute</h3>
          <ul style="margin-left:40px">
            <li>Report visual bugs or accessibility issues by emailing <a href="mailto:ky25aaa@herts.ac.uk">ky25aaa@herts.ac.uk</a>.</li>
            <li>To contribute code, fork the GitHub repository, make changes on a feature branch, and open a pull request. Please include concise commit messages describing each change.</li>
            <li>If you add server-side features, document any new dependencies and update the README with run steps.</li>
          </ul>

          <h3>Known issues / TODO</h3>
          <ol style="margin-left:40px">
            <li>Improve form autosave for the post-ad workflow.</li>
            <li>Add unit/integration tests for JS components and server endpoints.</li>
            <li>Integrate a map API for location filtering and display.</li>
            <li>Replace stubbed endpoints with a simple backend (Node/PHP) and a lightweight database for persistence.</li>
          </ol>

          <h3>Credits</h3>
          <p>Project by Kai Young, Will Cooper and Daniel Zhang for the DUX module. For questions or test requests contact <a href="mailto:ky25aaa@herts.ac.uk">ky25aaa@herts.ac.uk</a>.</p>

          <p style="font-size:0.9em; color:#666;">Note: this repository and the deployed prototype are for educational purposes only and are not intended to collect or process real user data.</p>

        </div>
