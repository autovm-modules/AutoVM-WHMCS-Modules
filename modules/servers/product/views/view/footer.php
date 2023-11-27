
    </div>
        </div>
        <!-- end container -->
    </div>
    
    <!-- Fotter file -->
    <!-- scripts vue -->
    <script src="/modules/servers/product/views/view/assets/js/apexcharts.js"></script>
    <script src="/modules/servers/product/views/view/assets/js/lodash.min.js"></script>
    <script src="/modules/servers/product/views/view/assets/js/axios.min.js"></script>
    <script src="/modules/servers/product/views/view/assets/js/vue.global.js"></script>
    
    



    <!-- Language file -->
    <?php if ($templatelang == 'Russian'): ?>
        <script src="/modules/servers/product/views/view/assets/js/lang/ru.js"></script>
    <?php elseif ($templatelang == 'French'): ?>
        <script src="/modules/servers/product/views/view/assets/js/lang/fr.js"></script>
    <?php elseif ($templatelang == 'Deutsch'): ?>
        <script src="/modules/servers/product/views/view/assets/js/lang/du.js"></script>
    <?php elseif ($templatelang == 'Farsi'): ?>
        <script src="/modules/servers/product/views/view/assets/js/lang/fa.js"></script>
    <?php elseif($templatelang == 'Turkish'): ?> 
        <script src="/modules/servers/product/views/view/assets/js/lang/tr.js"></script>
    <?php elseif($templatelang == 'Brizilian'): ?> 
        <script src="/modules/servers/product/views/view/assets/js/lang/br.js"></script>
    <?php elseif($templatelang == 'Italian'): ?> 
        <script src="/modules/servers/product/views/view/assets/js/lang/it.js"></script>
    <?php elseif($templatelang == 'English'): ?> 
        <script src="/modules/servers/product/views/view/assets/js/lang/defaulten.js"></script>
    <?php else: ?> 
        <script src="/modules/servers/product/views/view/assets/js/lang/defaulten.js"></script>
    <?php endif ?>
        



    
    <script src="/modules/servers/product/views/view/assets/js/main.js?v=<?php echo time(); ?>"></script>

    </body>
</html>
<!-- ?v=' . time() . ' -->