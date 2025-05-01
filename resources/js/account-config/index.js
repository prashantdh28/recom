import { filterStatus, search } from "../common/datatable";
import { errorMessage, successMessage } from "../common/toastr";
import { updateStatus } from "../common/update-status";
import { tableId, module } from "./config";

/** For Status Update. I'd like to know which records have been active. */
updateStatus(module);

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