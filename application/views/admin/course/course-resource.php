 <?php init_header(); ?>
 <style>
     .btn-purple {
         background-color: #6f42c1;
         color: #fff;
     }

     .btn-purple:hover {
         background-color: #59339d;
         color: #fff;
     }
 </style>

 <div class="main-content">
     <div class="content-page">
         <!-- Start content -->
         <div class="content">
             <div class="container-fluid">
                 <div class="page-title-box">
                     <div class="row align-items-center">
                         <div class="col-sm-6">
                             <h4 class="page-title"></h4>
                         </div>
                         <div class="col-sm-6">
                             <div class="float-right d-none d-md-block">
                                 <button type="button" class="btn btn-secondary waves-effect waves-light mb-0"
                                     onclick="window.history.back()">Back</button>
                             </div>
                         </div>
                     </div>
                 </div>
                 <div class="row">
                     <div class="col-12">
                         <div class="card">
                             <div class="card-body">
                                 <h4 class="mt-0 header-title m-b-20"><?= $title; ?></h4>

                                 <div data-repeater-list="resources">

                                     <?php if (!empty($resources)) : ?>
                                         <?php foreach ($resources as $res) : ?>
                                             <div data-repeater-item class="row align-items-end mb-3">

                                                 <input type="hidden" name="resource_id" value="<?= $res['id']; ?>">

                                                 <div class="col-md-4">
                                                     <label>File Name</label>
                                                     <input type="text"
                                                         name="file_name"
                                                         class="form-control"
                                                         value="<?= $res['title']; ?>"
                                                         required>
                                                 </div>

                                                 <div class="col-md-5">
                                                     <label>Select File</label>
                                                     <input type="file"
                                                         name="file"
                                                         class="form-control resource-file"
                                                         onchange="updatePreviewButton(this)">
                                                     <small class="text-muted">
                                                         Current: <?= $res['file']; ?>
                                                     </small>
                                                 </div>

                                                 <div class="col-md-2">
                                                     <label>&nbsp;</label>
                                                     <a href="<?= base_url(COURSE_RESOURCES . $res['file']); ?>"
                                                         target="_blank"
                                                         class="btn btn-info btn-block">
                                                         View
                                                     </a>
                                                 </div>

                                                 <div class="col-md-1 text-center">
                                                     <label>&nbsp;</label>
                                                     <button data-repeater-delete type="button"
                                                         class="btn btn-danger">
                                                         <i class="fas fa-trash"></i>
                                                     </button>
                                                 </div>

                                             </div>
                                         <?php endforeach; ?>
                                     <?php else : ?>

                                         <!-- EMPTY ROW FOR ADD MODE -->
                                         <div data-repeater-item class="row align-items-end mb-3">

                                             <div class="col-md-4">
                                                 <label>File Name</label>
                                                 <input type="text" name="file_name" class="form-control" required>
                                             </div>

                                             <div class="col-md-5">
                                                 <label>Select File</label>
                                                 <input type="file" name="file" class="form-control">
                                             </div>

                                             <div class="col-md-2"></div>

                                             <div class="col-md-1 text-center">
                                                 <button data-repeater-delete type="button" class="btn btn-danger">
                                                     <i class="fas fa-trash"></i>
                                                 </button>
                                             </div>

                                         </div>

                                     <?php endif; ?>

                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>


 <?php init_footer(); ?>

 <script src="<?= base_url(); ?>assets/plugins/jquery-repeater/jquery.repeater.min.js">
 </script>
 <script src="<?= base_url(); ?>assets/pages/form-repeater.int.js"></script>
 <script src="https://cdn.ckeditor.com/4.15.0/full-all/ckeditor.js"></script>
 </script>

 <script type="text/javascript">
     CKEDITOR.replace('benefits', {
         height: '150px'
     });
     CKEDITOR.replace('notes', {
         height: '380px'
     });
 </script>
 <script type="text/javascript">
     $("#skill_id").select2({
         placeholder: "Select Skill",
         allowClear: true,
         width: '100%'
     });
 </script>
 <script>
     function updatePreviewButton(input) {

         const row = input.closest('[data-repeater-item]');
         const btn = row.querySelector('.preview-btn');
         const file = input.files[0];

         if (!file) return;

         const ext = file.name.split('.').pop().toLowerCase();

         let icon = 'fa-file';
         let colorClass = 'btn-secondary';

         if (ext === 'pdf') {
             icon = 'fa-file-pdf';
             colorClass = 'btn-danger';
         } else if (['doc', 'docx'].includes(ext)) {
             icon = 'fa-file-word';
             colorClass = 'btn-primary';
         } else if (['xls', 'xlsx'].includes(ext)) {
             icon = 'fa-file-excel';
             colorClass = 'btn-success';
         } else if (['ppt', 'pptx'].includes(ext)) {
             icon = 'fa-file-powerpoint';
             colorClass = 'btn-warning';
         } else if (['jpg', 'jpeg', 'png', 'gif'].includes(ext)) {
             icon = 'fa-file-image';
             colorClass = 'btn-info';
         } else if (['zip', 'rar'].includes(ext)) {
             icon = 'fa-file-archive';
             colorClass = 'btn-dark';
         } else if (['mp4', 'avi', 'mkv'].includes(ext)) {
             icon = 'fa-file-video';
             colorClass = 'btn-purple';
         }

         // Apply changes
         btn.className = 'btn btn-block preview-btn ' + colorClass;
         btn.innerHTML = `<i class="fas ${icon}"></i> Preview`;
     }

     function previewFile(btn) {

         const row = btn.closest('[data-repeater-item]');
         const fileInput = row.querySelector('input[type="file"]');

         if (!fileInput.files.length) {
             alert('Please select a file first');
             return;
         }

         const fileURL = URL.createObjectURL(fileInput.files[0]);
         window.open(fileURL, '_blank');
     }
 </script>