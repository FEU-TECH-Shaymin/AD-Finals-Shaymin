<?php
declare(strict_types=1);

function footerComponent(): void
{
    // Load static footer data
    include_once STATICDATAS_PATH . '/footer.staticData.php';
    ?>
    <footer class="footer">
      <div class="container">
        <footer class="py-5">
          <div class="row">
            <div class="col-6 col-md-2 mb-3">
              <ul class="footer flex-column list-unstyled">
                <?php foreach ($footerLinks as $link): ?>
                  <li class="footer-item mb-2">
                    <a href="<?= htmlspecialchars($link['url']) ?>" class="footer-link p-0 text-body-secondary">
                      <?= htmlspecialchars($link['label']) ?>
                    </a>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
            <div class="col-6 col-md-2 mb-3">
              <h5>Web Designer</h5>
              <h6>Shaymin</h6>
            </div>
            <div class="col-md-7 offset-md-1 mb-3">
              <img src="/assets/img/outlastLogo.png" alt="Outlast Logo">
            </div>
          </div>
          <div class="d-flex flex-column flex-sm-row justify-content-between py-4 my-4 border-top">
            <p>Copyright © 2025 Outlast. All rights reserved.</p>
          </div>
        </footer>
      </div>
    </footer>
    <?php
}
?>