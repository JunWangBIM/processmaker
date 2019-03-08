---
description: Edit the configuration and notifications for a Process.
---

# Edit Process Configuration

## Edit Process Configuration

{% hint style="info" %}
### Looking for Process Model Editing?

Process configuration is different than Process model editing. See [Model Your Process](../../process-design/model-your-process/) for topics.

### Permissions Required

Your user account or group membership must have the following permissions to edit a Process's configuration:

* Processes: View Processes
* Processes: Edit Processes

See the [Process](../../../processmaker-administration/permission-descriptions-for-users-and-groups.md#processes) permissions or ask your ProcessMaker Administrator for assistance.
{% endhint %}

Follow these steps to edit Process configuration information:

1. [View your active Processes.](./#view-your-processes) The **Processes** page displays.
2. Select the **Config** icon![](../../../.gitbook/assets/configure-process-icon-processes-page-processes.png)for your Process. The **Edit** page displays.  

   ![](../../../.gitbook/assets/edit-process-page-processes.png)

3. Edit the following Process configuration as necessary:
   * In the **Name** field, edit the Process name. This is a required field.
   * In the **Description** field, edit the description of the Process. This is a required field.
   * From the **Category** drop-down, select to which category to assign the Process. This is a required field. See [Process Categories](../process-categories.md) for more information how this affects new [Requests](../../../using-processmaker/requests/what-is-a-request.md) for the Process.
   * From the **Cancel Request** drop-down, specify from which users or groups have permission to cancel Requests from this Process. If no users or groups are selected, no one can cancel a Request from this Process. Follow these guidelines:

     * **Select User\(s\)/Group\(s\):** Select which user\(s\) and/or group\(s\) have permission to cancel Requests from this Process. Multiple users and/or can be selected. Use **Shift** to select multiple consecutive users/groups or use **Ctrl** to select multiple non-consecutive users/groups.
     * **Remove User\(s\)/Group\(s\):** To remove a user or group added to this field, either click the icon![](../../../.gitbook/assets/close-remove-delete-user-group-processes.png)for that user/group or mouse-hover over the user/group and press **Enter**.   

     ![](../../../.gitbook/assets/close-remove-delete-user-group-drop-down-processes.png)

   * From the **Cancel Screen** drop-down, select a ProcessMaker Screen to display when a Request for this Process is canceled.
   * From the **Edit Data** drop-down, specify from which users or groups have permission to [edit Request data](../../../using-processmaker/requests/request-details.md#editable-request-data) from this Process. If no users or groups are selected, no one can edit Request data from this Process. Follow these guidelines:
     * **Select User\(s\)/Group\(s\):** Select which user\(s\) and/or group\(s\) have permission to edit Request data from this Process. Multiple users and/or can be selected. Use **Shift** to select multiple consecutive users/groups or use **Ctrl** to select multiple non-consecutive users/groups.
     * **Remove User\(s\)/Group\(s\):** To remove a user or group added to this field, either click the icon![](../../../.gitbook/assets/close-remove-delete-user-group-processes.png)for that user/group or mouse-hover over the user/group and press **Enter**.   

       ![](../../../.gitbook/assets/close-remove-delete-user-group-drop-down-processes.png)
   * Select the **Pause Timer Start Events** checkbox to pause [Start Timer Event](../../process-design/model-your-process/add-and-configure-start-timer-event-elements.md) elements configured in the Process model.
4. Click **Save**.

## Edit Process Notifications

{% hint style="info" %}
Your user account or group membership must have the following permissions to edit a Process's notifications:

* Processes: View Processes
* Processes: Edit Processes

See the [Process](../../../processmaker-administration/permission-descriptions-for-users-and-groups.md#processes) permissions or ask your ProcessMaker Administrator for assistance.
{% endhint %}

Configure Process notifications to notify Process Requesters and/or participants when any of the following Request events occur:

* Request started: A Request for this Process was started.
* Request canceled: A Request for this Process was canceled.
* Request completed: A Request for this Process was completed.

Follow these steps to edit Process configuration notifications:

1. [View your active Processes.](./#view-your-processes) The **Processes** page displays.
2. Select the **Config** icon![](../../../.gitbook/assets/configure-process-icon-processes-page-processes.png)for your Process. The **Edit** page displays.
3. Click the **Notifications** tab.  

   ![](../../../.gitbook/assets/edit-process-notifications-processes.png)

4. Change the following Request notification settings as necessary:
   * Notify Requester: A Requester is any user or group member who has granted permission to start a Request for this Process.
   * Notify Request participants: 
5. Click **Save**.

## Related Topics

{% page-ref page="../what-is-a-process.md" %}

{% page-ref page="view-your-processes.md" %}

{% page-ref page="create-a-process.md" %}

{% page-ref page="import-a-bpmn-compliant-process.md" %}

{% page-ref page="search-for-a-process.md" %}

{% page-ref page="export-a-bpmn-compliant-process.md" %}

{% page-ref page="remove-a-process.md" %}

{% page-ref page="restore-a-process.md" %}

{% page-ref page="../process-categories.md" %}
