import { errorMessage, successMessage } from "./toastr";

export const updateStatus = (module) => {
    $(document).on("change", "input[name='check']", function(e){
        e.preventDefault();
        
        const id = $(this).parent().parent().parent('tr').attr('id');

        axios.put(route('update-status'), {
            id, module
        }).then((response) => {
            successMessage(response?.data?.message || 'Success')
        }).catch((error) => {
            errorMessage(error?.response?.data?.message || 'Something went wrong')
        })
    })
}