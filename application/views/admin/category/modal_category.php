<style>
  @media (min-width: 992px) {

    .modal-lg,
    .modal-xl {
      max-width: 1000px;
    }
  }

  b,
  strong {
    font-weight: 600;
  }

  #_cate_image,
  #_parent_cate {
    display: none;
  }

  .category-warning {
    border-left: 4px solid #f39c12;
    background: #fff8e6;
    border-radius: 8px;
  }

  .category-warning ul {
    margin-top: 10px;
    margin-bottom: 10px;
    padding-left: 20px;
  }

  .category-usage-box {
    background: #fcf8f8;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 15px;
    margin-bottom: 20px;
  }

  .usage-header {
    display: flex;
    align-items: center;
    margin-bottom: 12px;
  }

  .usage-icon {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    background: #eef2ff;
    color: #ff4747;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
    font-size: 18px;
  }

  .usage-header h6 {
    margin: 0;
    font-weight: 600;
    color: #111827;
  }

  .usage-header small {
    color: #6b7280;
  }

  .usage-courses {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
  }

  .course-badge {
    background: #ffffff;
    border: 1px solid #dbeafe;
    color: #ff4747;
    border-radius: 30px;
    padding: 7px 12px;
    font-size: 13px;
    font-weight: 500;
  }
</style>

<div id="categoryModal"
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
        action="<?= base_url(ADMIN . 'Category/add') ?>"
        id="categoryFrm"
        enctype="multipart/form-data">

        <input type="hidden"
          name="id"
          id="id"
          value="<?= ($category) ? $category['id'] : '' ?>">

        <div class="modal-body">

          <div class="form-group">

            <label>
              Category Name
            </label>

            <input type="text"
              class="form-control"
              required
              placeholder="Enter Category Name"
              name="category_name"
              value="<?= ($category) ? $category['category_name'] : ''; ?>">

          </div>

          <?php if (!empty($used_courses)) { ?>

            <div class="category-usage-box">

              <div class="usage-header">

                <div>
                  <h6 class="mb-1"><i class="fas fa-book"></i> Used In Courses</h6>
                  <small>
                    This category is currently assigned to
                    <?= count($used_courses); ?> course(s)
                  </small>
                </div>
              </div>

              <div class="usage-courses">

                <?php foreach ($used_courses as $course) { ?>

                  <div class="course-badge">
                    <i class="fas fa-graduation-cap mr-1"></i>
                    <?= $course['title']; ?>
                  </div>

                <?php } ?>

              </div>

            </div>

          <?php } ?>

          <div class="form-group">

            <label>
              Status
            </label>

            <div>

              <label class="mr-4">

                <input type="radio"
                  name="status"
                  value="1"
                  <?= ($category && $category['status'] == 1) ? 'checked' : ''; ?>
                  <?= (!$category) ? 'checked' : ''; ?>>

                Active

              </label>

              <label>

                <input type="radio"
                  name="status"
                  value="0"
                  <?= ($category && $category['status'] == 0) ? 'checked' : ''; ?>>

                In-Active

              </label>

            </div>

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

            <?= !empty($category['id']) ? 'Update Category' : 'Add Category'; ?>

          </button>

        </div>

      </form>

    </div>
  </div>

</div>