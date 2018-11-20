<?php 

echo '<!DOCTYPE html><html>
<head>
    <link rel="stylesheet" href="https://sdks.shopifycdn.com/polaris/2.12.1/polaris.min.css" />
    <title>NexusMedia</title>';

echo '</head>
<body>'; 

    echo "Buongorno!"; 

    echo '<!-- We will put our React component inside this div. -->
    <div id="root"></div>

    <!-- Load React. -->
    <!-- Note: when deploying, replace "development.js" with "production.min.js". -->
    <script src="https://unpkg.com/react@16/umd/react.development.js" crossorigin></script>
    <script src="https://unpkg.com/react-dom@16/umd/react-dom.development.js" crossorigin></script>

    <!-- Load our React component. -->
    <script src="/public/index.js"></script>';

    echo '<script>
    </script>'; 

echo '</body>
</html>';

?>