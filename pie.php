    </div>
    </div>
    </div>
    <div id="jsfoot">
        <?php if(isset($_params['js_foot']) && count($_params['js_foot'])): ?>
        <?php for($i=0; $i < count($_params['js_foot']); $i++): ?>
        
        <script src="<?php echo $_params['js_foot'][$i] ?>" type="text/javascript"></script>
        
        <?php endfor; ?>
        <?php endif; ?>
    </div>
    <footer>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
            <!-- Copyright info -->
            <p class="copy">Copyright &copy; 2014 | <a href="javascript:">Aquinos Gráfica Integral</a> </p>
      </div>
    </div>
  </div>
</footer> 
    <span class="totop"><a href="#"><i class="icon-chevron-up"></i></a></span> 
    <script src="<?php echo BASE_URL ?>lib/admin/js/bootstrap.js"></script>
    <script src="<?php echo BASE_URL ?>lib/admin/js/custom.js"></script>

    </body>
</html>