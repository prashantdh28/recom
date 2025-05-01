import { filterStatus, search } from "../common/datatable";
import { tableId } from "./config";
import { errorMessage, successMessage } from "../common/toastr";

/** For Search the record & Draw the DataTable. */
search(tableId);

/** For Filter Status(Active, Inactive) the record & Draw the DataTable. */
filterStatus(tableId);

/** Toast Message with Success Message */
if (window.flashMessage.success) {
    successMessage(window.flashMessage.success);
}
/** Toast Message with Error Message */
if (window.flashMessage.error) {
    errorMessage(window.flashMessage.error);
}