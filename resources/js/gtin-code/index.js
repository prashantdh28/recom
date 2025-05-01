import axios from "axios";
import { filterStatus, search } from "../common/datatable";
import { tableId } from "./config";
import { errorMessage, successMessage } from "../common/toastr";

/** For Search the record & Draw the DataTable. */
search(tableId);

/** For Filter Status(Active, Inactive) the record & Draw the DataTable. */
filterStatus(tableId);

/** Generate the QR Code and Download it. */
$(document).on('click', '.download-code', function(e) {
    e.preventDefault();
    
    const link = $(this)?.data('link');

    axios.post(link).then((response) => {
        console.log('response', response);

        if(response?.data?.status == 200){
            successMessage(response?.data?.message);
            let a = window.open(route('transparency-code.get-qr-code'), '_blank');
            a.print();
        }else{
            errorMessage(response?.data?.message);
            console.log('error');
        }

    }).catch((error) => {
        console.log('error', error);
    })
})