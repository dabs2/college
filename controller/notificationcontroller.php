<?php

namespace College\Ddcollege\Controller;

class notificationcontroller
{
    public function ThrowSuccessNotification($message, $title)
    {
        ?>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                }
                toastr.options.positionClass = "toast-top-right";
                toastr.success('<?= $message ?>', '<?=$title?>');
            });
        </script>
        <?php

    }

    public function ThrowErrorNotification($message, $title)
    {
        ?>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "6000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                }
                toastr.options.positionClass = "toast-top-right";
                toastr.error('<?= $message ?>', '<?=$title?>');
            });
        </script>
        <?php

    }
}