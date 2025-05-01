/** Set the Configuration of Toast Messages */
toastr.options = {
    "closeButton": true
}

/** Toast Message with Success Message */
export const successMessage = (message) => {
    toastr.success(message);
}

/** Toast Message with Error Message */
export const errorMessage = (message) => {
    toastr.error(message);
}