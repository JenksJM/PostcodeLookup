function validatePostcodes(postcodes){
    // js fallback check blank
    if (!postcodes.trim()){
        triggerErrorMessage('No Data Entered', 'Please Enter a Postcode');
        return false;
    }

    // seperate postcodes into array
    var postcodeArray = postcodes.split(',');
    var invalidPostcodes = new Array();

    postcodeArray.forEach(function(postcode) {
        // check each postcode is valid
        if (!postcodeValidator(postcode)){
            invalidPostcodes.push(postcode);
        }
    });
    
    if (invalidPostcodes.length){
        triggerErrorMessage('Invalid Postcodes', invalidPostcodes);
        return false;
    }
    return true;
}

function triggerErrorMessage(title, body){
    $('#errorModal').find('.modal-title').text(title);
    $('#errorModal').find('.modal-body').text(body);
    $('#errorModal').modal('show');
}

//postcode validation from https://stackoverflow.com/questions/13969461/javascript-uk-postcode-validation
function postcodeValidator(postcode) {
    postcode = postcode.replace(/\s/g, "");
    const regex = /^[A-Z]{1,2}[0-9]{1,2}[A-Z]{0,1} ?[0-9][A-Z]{2}$/i;
    return regex.test(postcode);
}