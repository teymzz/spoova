<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="@mapp('images/icons/favicon.png')">
    <title>Invalid Request</title>
    @Res(':headers') 
</head>
<body>

    <section class="csrf grid-center vhm-full" style="background-color: rgb(195, 195, 204);">
        <div class="formc-red font-menu font-em-d85 calibri box-3s centre">
            <div class="box-3s centre">
                <div class="bc-white shadow rad-5 flow-hide ">
                        <div class="bc-white-dd pxv-10 c-red-dd"> <i class="bi-bug"></i> @error(':csrf','title') </div>
                        <div class="pxv-20 text-muted">
                            <div class="pvs-10">
                                @error(':csrf','info')
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </section>

</body>
</html>