<?php
declare(strict_types=1);

include_once TEMPLATES_PATH . "/footer.component.php";

function footer(array $pageJs = []): void
{
    footerComponent();
    ?>
    </main>

    </body>
    </html>
    <?php
}
?>