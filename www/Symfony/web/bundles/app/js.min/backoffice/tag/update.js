$(document).ready(function(){$("#delete_button").click(function(){$("#delete_wrapper").show()}),$("#delete_no_button").click(function(){$("#delete_wrapper").hide()}),$("#delete_yes_button").click(function(){$.post(deleteUrl).done(function(e){window.location.href=e})})});