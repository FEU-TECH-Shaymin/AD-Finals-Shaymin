<?php
declare(strict_types=1);

include_once TEMPLATES_PATH . "/footer.component.php";

function footer(array $pageJs = []): void
{
    footerComponent();
    ?>
    </main>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Site Main JS -->
    <script src="/assets/js/script.js"></script>

    <!-- Custom page-level JS -->
    <?php
    if (!empty($pageJs)) {
        foreach ($pageJs as $jsFile) {
            echo "<script src=\"" . htmlspecialchars($jsFile) . "\"></script>\n";
        }
    }
    ?>

    </body>
    </html>
    <?php
}
?>