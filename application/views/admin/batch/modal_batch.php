<style>
  @media (min-width: 992px) {
    .modal-lg,
    .modal-xl {
      max-width: 800px;
    }
  }

  b,
  strong {
    font-weight: 600;
  }
</style>

<div id="batchModal"
  class="modal fade"
  tabindex="-1"
  role="dialog"
  aria-labelledby="myModalLabel"
  aria-hidden="true">

  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">
          <?= $sub_title; ?>
        </h5>

        <button type="button"
          class="close"
          data-dismiss="modal"
          aria-hidden="true">
          ×
        </button>
      </div>

      <form method="post"
        action="<?= base_url(ADMIN . 'Batch/add') ?>"
        id="batchFrm">

        <input type="hidden"
          name="id"
          id="id"
          value="<?= (!empty($batch)) ? $batch['id'] : '' ?>">

        <div class="modal-body">

          <div class="form-group">
            <label>
              Batch Name <span class="text-danger">*</span>
            </label>

            <input type="text"
              class="form-control"
              required
              placeholder="Enter Batch Name"
              name="batch_name"
              value="<?= (!empty($batch)) ? html_escape($batch['batch_name']) : ''; ?>">
          </div>

          <div class="form-group">
            <label>
              Batch Description
            </label>

            <textarea class="form-control"
              rows="4"
              placeholder="Enter Batch Description"
              name="batch_description"><?= (!empty($batch)) ? html_escape($batch['batch_description']) : ''; ?></textarea>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button"
            class="btn btn-secondary"
            data-dismiss="modal">
            Close
          </button>

          <button type="submit"
            class="btn btn-primary">
            <?= !empty($batch['id']) ? 'Update Batch' : 'Add Batch'; ?>
          </button>
        </div>

      </form>

    </div>
  </div>

</div>
