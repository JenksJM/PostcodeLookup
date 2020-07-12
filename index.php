<?php
    include('postcodeApi.php');
    include('address.php');    
    if (isset($_POST['postcode'])){
        $postcode = new PostcodeAPI();
        $postcode->set_postcodes($postcode->formatPostcodes($_POST['postcode']));
        $postcode->dynamicPostcodeLookup();
    }  
?>
<!DOCTYPE html>
<html>

<head>
    <title>PostCode Lookup</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <!-- Entry form -->
        <div class="row" style="padding-top: 200px;">
            <div class="col-3"></div>
            <div class="col-6">
                <form method="post" class="text-center" onsubmit="return validatePostcodes(this.postcode.value);"
                    action="">

                    <p class="h4">Post Code Lookup</p>

                    <!-- PostCodes -->
                    <input type="text" id="postcode" name="postcode" class="form-control" placeholder="Postcode" required>
                    <small id="postcodeHelp" class="form-text text-muted">For multiple emails please use a comma between
                        each postcode</small>

                    <!-- Submit Button -->
                    <button class="btn btn-primary" type="submit">Lookup Postcode</button>

                </form>
            </div>
            <div class="col-3"></div>
        </div>

        <!-- Results -->
        <?php if(isset($_POST['postcode'])) : ?>
            <div style="padding-top: 100px;" class="row">
                <div class="col-3"></div>
                <div class="col-6">
                    <p class="h4">Results</p>
                    <table class="table">
                        <?php foreach($postcode->get_addresses() as $address): ?>
                            <thead class="thead-dark">
                                <tr>
                                    <th colspan="2">Query: <?php echo $address->get_query(); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Postcode</td>
                                    <td><?php echo $address->get_postcode(); ?></td>
                                </tr>
                                <tr>
                                    <td>Parish</td>
                                    <td><?php echo $address->get_parish(); ?></td>
                                </tr>
                                <tr>
                                    <td>District</td>
                                    <td><?php echo $address->get_adminDistrict(); ?></td>
                                </tr>
                                <tr>
                                    <td>Country</td>
                                    <td><?php echo $address->get_country(); ?></td>
                                </tr>
                                <tr>
                                    <td>Longitute</td>
                                    <td><?php echo $address->get_longitude(); ?></td>
                                </tr>
                                <tr>
                                    <td>Latitude</td>
                                    <td><?php echo $address->get_latitude(); ?></td>
                                </tr>
                            </tbody>
                        <?php endforeach; ?>
                    </table>  
                </div>
                <div class="col-3"></div>
            </div>
        <?php endif; ?>

        <!-- Modal -->
        <div class="modal fade" id="errorModal" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">...</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- javascript -->
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js"
        integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"
        integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"
        integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn"
        crossorigin="anonymous"></script>
    <script src="js/validation.js"></script>
</body>

</html>