<script type="text/javascript">
function confirmDelete() {
  if (confirm("Are you sure you want to delete this technique?")) {
    window.location = "/<? echo $content['MOD_NAME']; ?>/<? echo $qa[0]; ?>/delete";
  }
}
</script>