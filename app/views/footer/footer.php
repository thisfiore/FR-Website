<!-- chiudo il div CONTENT -->
</div>

<footer>
<div class="container">
<div class="row">
<div class="span12">
<!-- <p class="pull-right">Admin Theme by Nathan Speller</p> -->
<!-- <p>&copy; Copyright 2013 FreelanceLeague</p> -->
</div>
</div>
</div>
</footer>
</body>
<script type="text/javascript" src="/js/admin/d3-setup.js"></script>
<script>protocol = window.location.protocol === 'http:' ? 'ws://' : 'wss://'; address = protocol + window.location.host + window.location.pathname + '/ws'; socket = new WebSocket(address);
socket.onmessage = function(msg) { msg.data == 'reload' && window.location.reload() }</script>
</html>