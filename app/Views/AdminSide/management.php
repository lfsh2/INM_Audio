<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?= base_url('assets/img/logo.png') ?>" type="image/x-icon">
	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
    <link rel="stylesheet" href="<?= base_url('Admin/css/management.css') ?>">
	<link rel="stylesheet" href="<?= base_url('Admin/css/dashboard1.css') ?>">
	<link rel="stylesheet" href="<?= base_url('Admin/css/notifModal.css') ?>">

	<title>Management</title>

    <style>    
        :root {
            --poppins: 'Poppins', sans-serif;
            --lato: 'Lato', sans-serif;

            --light: #f5f5f5;
            --blue: #3C91E6;
            --light-blue: #CFE8FF;
            --grey: #eee;
            --dark-grey: #AAAAAA;
            --dark: #2e2e2e;
            --red: #DB504A;
            --yellow: #FFCE26;
            --light-yellow: #FFF2C6;
            --orange: #FD7238;
            --light-orange: #FFE0D3;
        }
        body.dark {
            --light: #0C0C1E;
            --grey: #060714;
            --dark: #FBFBFB;
        }
    
        .modal-content {
            .content {
                .input-block {
                    width: 100%;
                    padding: 10px;
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
        
                    label, input, select{
                        width: 50%;
                        padding: 10px;
                        color: var(--dark) !important;
                    }
                    input, select, textarea {
                        border: 1px solid var(--dark) !important;
                        background: var(--light) !important;
                        color: var(--dark) !important;
                    }
                    input::placeholder {
                        color: var(--dark);
                    }
                    .no {
                        color: red;
                    }
                }
                .modal-button {
                    width: 50%;
                    margin: 0 auto;
                    display: flex;
                    gap: 10px;
        
                    button, a {
                        padding: 10px;
                        border-radius: 10px;
                        background: var(--dark);
                        color: var(--light);
                        border: none;
                        cursor: pointer;
                        flex-grow: 1;
                        font-size: 1rem;
                    }
        
                    button:nth-child(1) {
                        background: rgb(55, 131, 255);
                    }
                    button:nth-child(2) {
                        background: red;
                    }
                }
            }
        }
    </style>
</head>
<body>


	<!-- SIDEBAR -->
    <?php echo view('AdminSide/includes/notifModal') ?>
	<?php echo view('AdminSide/includes/sideNav1') ?>
	<!-- SIDEBAR -->



	<!-- CONTENT -->
	<section id="content">
        <?php echo view('AdminSide/includes/topNavbar') ?>

		<!-- MAIN -->
		<main class="management">
			<div class="head-title">
				<div class="left">
                    <div class="top">
                        <h1>Management</h1>

                        <div class="btns">
                            <button id="openGearModal" class="modalButton">
                                <p>Add Gear</p>
                            </button>
            
                            <button id="openCategoriesModal" class="modalButton">
                                <p>Add Category</p>
                            </button>
                        </div>
                    </div>
                    <!-- SUCCESS MESSAGE -->
                    <?php if(session()->getFlashdata('catAdded')) :?>
                        <span style="color: darkgreen;"><?= esc(session()->get('catAdded')) ?></span>
                    <?php endif;?>
                    <?php if(session()->getFlashdata('catDeleted')) :?>
                        <span style="color: darkgreen;"><?= esc(session()->get('catDeleted')) ?></span>
                    <?php endif;?>
                    <?php if(session()->getFlashdata('gearAdded')) :?>
                        <span style="color: darkgreen;"><?= esc(session()->get('gearAdded')) ?></span>
                    <?php endif;?>

                    <!-- ERROR MESSAGE -->
                    <?php if(session()->getFlashdata('catError')) :?>
                        <span style="color:darkred;"><?= esc(session()->get('catError')) ?></span>
                    <?php endif;?>
                    <?php if(session()->getFlashdata('gearError')) :?>
                        <span style="color:darkred;"><?= esc(session()->get('gearError')) ?></span>
                    <?php endif;?>
					<ul class="breadcrumb">
						<!-- <li>
							<a href="#">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="#">Home</a>
						</li> -->
					</ul>
				</div>
			</div>

            <div class="admin-table">
                <div class="tabs">
                    <div class="btns">
                        <button onclick="switchTab('table1')">Gears</button>
                        <button onclick="switchTab('table2')">Categories</button>
                    </div>
                </div>
                
                <div class="container">                    
                    <!-- GEARS -->
                    <div id="table1" class="tab-content active">
                        <h2>GEARS</h2>
                        <table>
                            <thead>
                                <tr>
                                    <th>Item ID</th>
                                    <th>Item</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Category</th>
                                    <th>Action</th>                        
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(isset($gears) && !empty($gears)) :?>
                                    <?php foreach($gears as $index => $gear) : ?>
                                    <tr>
                                        <td class="th one"><?= esc($gear['product_id']) ?></td>
                                        <td class="th two">
                                            <a href="<?= esc($gear['image_url']) ?>" title="click the image to view" target="_blank">
                                                <img src="<?= esc($gear['image_url']) ?>" alt="image">
                                            </a>
                                            <p><?= esc($gear['product_name']) ?></p>
                                        </td>
                                        <td class="th three"><?= esc($gear['price']) ?></td>
                                        <?php if($gear['stock_quantity'] > 15) : ?>
                                            <td class="th four">
                                                <?= esc($gear['stock_quantity']) ?>
                                            </td>
                                        <?php else :?>
                                            <td class="th four" style="color: red"  title="low on stock">
                                                <?= esc($gear['stock_quantity']) ?>
                                            </td>
                                        <?php endif;?>
                                        
                                        </td>
                                        <td class="th five">
                                            <?php if($gear['category']) :?> 
                                                <?= esc($gear['category']) ?>
                                            <?php else : ?>
                                                <p style="color: red;">Category not set</p>
                                            <?php endif; ?>
                                        </td>
                                        <td class="th six">
                                            <div class="buttons">
                                                <a href="#" class="confirm view-button" data-target="gearItem-<?= $index ?>">View</a>
                                                <a href="<?= base_url('/admin/gears/removeGears/'. $gear['product_id']) ?>" class="cancel">Remove</a>
                                            </div>
                                        </td>              
                                    </tr>
    
                                    <!-- MODAL FOR VIEWING EACH ITEM --> 
                                    <div id="gearItem-<?= $index ?>" class="modal">
                                        <div class="modal-content">
                                            <div class="add">
                                                <span class="close close-gear"></span>
                                                <h3><?= esc($gear['product_name'])?></h3></h2>
                                            </div>
                                            <div class="content">
                                                <form action="<?= base_url('/admin/updateGear/'. $gear['product_id']) ?>" method="post"  enctype="multipart/form-data">
                                                    <img src="<?= esc($gear['image_url']) ?>" alt="image">
                                                    
                                                    <div class="input-block">
                                                        <h3 class="edit-mode" style="display: none;">Item Name:</h3>
                                                        <input type="text" name="gearName" class="edit-mode" value="<?= esc($gear['product_name'])?>" style="display: none;">
                                                    </div>
                                                    <div class="input-block">
                                                        <h3 class="edit-mode" style="display: none;">Image:</h3>
                                                        <input type="file" name="img" class="edit-mode" value="" style="display: none; border: none;">
                                                    </div>
                                                    <!-- DESCRIPTION -->
                    
                                                    <div class="input-block row">
                                                        <h3>Description</h3>
                                                        <p class="read-only"><?= esc($gear['description'])?></p>
                                                        <textarea name="description" class="edit-mode text" style="display: none; width: 50%; height: 100px;" ><?= esc($gear['description'])?></textarea>
                                                        <!-- <input type="" name="description" class="edit-mode" value="<?= esc($gear['description'])?>" style="display: none;"> -->
                                                    </div>
    
                                                    <div class="input-block row">
                                                        <h3>Category</h3>
                                                        <p class="read-only" style= "width: 50%;"><?= esc($gear['category']) ?></p>
                                                            <?php if (!empty($categories)) : ?>
                                                                <select name="category" id="category" class="edit-mode" style="display: none;">
                                                                    <?php foreach ($categories as $category) : ?>
                                                                        <option value="<?= esc($category['category_id']); ?>" 
                                                                            <?= $category['category'] === $gear['category'] ? 'selected' : ''; ?>>
                                                                            <?= esc($category['category']); ?>
                                                                        </option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            <?php else : ?>
                                                                <option value="" title="Will set to null if there is no category">No categories available</option>
                                                            <?php endif; ?>
                                                        </select>
                                                    </div>
                                                    <div class="input-block row">
                                                        <h3>Price</h3>
                                                        <p class="read-only"><?= esc($gear['price'])?></p>
                                                        <input type="number" name="price" class="edit-mode" value="<?= esc($gear['price'])?>" style="display: none; width: 50%;">
                                                    </div>
    
                                                    <div class="input-block row">
                                                        <h3>Stock</h3>
                                                        <p class="read-only"><?= esc($gear['stock_quantity'])?></p>
                                                        <input type="number" name="stock" class="edit-mode" value="<?= esc($gear['stock_quantity'])?>" style="display: none; width: 50%;">
                                                    </div>
    
                                                    <div class="input-block row">
                                                        <h3>Date Added</h3>
                                                        <p class="read-only"><?= esc($gear['created_at'])?></p>
                                                        <input type="text" name="dateAdded" class="edit-mode" value="<?= esc($gear['created_at'])?>" style="display: none; width: 50%;" disabled>
                                                    </div>
                                                        <!-- aA -->
                                                    <div class="modal-button">
                                                        <button type="button" id="editButton-<?= $index ?>">Edit</button>
                                                        <button type="submit" id="saveButton-<?= $index ?>" style="display: none; background: rgb(55, 131, 255);">Save</button>
                                                        <button type="button" id="cancelButton-<?= $index ?>" style="display: none;">Cancel</button>
                                                        <a href="<?= base_url('/admin/gears/removeGears/'. $gear['product_id']) ?>" class="remove-button" style=" background: red;">Remove Item</a>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                <?php else :?>
                                    <tr>
                                        <td colspan="8" id="zero">No Gears Added</td>
                                    </tr>
                                <?php endif; ?>          
                            </tbody>
                        </table>
                    </div>
    
                    <!-- CATEGORIES -->
                    <div id="table2" class="tab-content">
                        <h2>CATEGORIES</h2>
                        <table>
                            <thead>
                                <tr>
                                    <th>Category ID</th>
                                    <th>Category</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if(isset($categories) && !empty($categories)) :?>
                                <?php foreach($categories as  $category) : ?>
                                <tr>
                                    <td class="th one"><?= $category['category_id'] ?></td>
                                    <td class="th two"><?= $category['category'] ?></td>
                                    <td class="th six">
                                        <div class="buttons">
                                            <a href="<?= base_url('/admin/gears/removeCats/'. $category['category_id']) ?>" class="cancel" onclick="return confirm('Are you sure you want to delete this Category?\nGear that has this category will be unset')">
                                                Remove
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else :?>
                                <tr>
                                    <td colspan="8" style="color: #4f4f4f; opacity: .4; padding: 10px;">No Categories Added</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>            
                    </div>
                </div>
            </div>
        </div>
            
        <!-- --------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
        <!-- MODAL FOR ADDING NEW GEAR -->
        <div id="gearModal" class="modal">
            <div class="modal-content">
                <div class="add">
                    <span class="close close-gear"></span>
                    <h2>Add Gear</h2>
                </div>
                <div class="content">
                    <form action="<?= base_url('/admin/gears/addGear') ?>" method="post" enctype="multipart/form-data">
                        <div class="input-block">
                            <label for="gearname">Gear name</label>
                            <input type="text" name="gearname" id="gearname" placeholder="Enter Gear Name"  required>
                        </div>

                        <div class="input-block">
                            <label for="description">Description</label>
                            <input type="text" name="description" id="description" placeholder="Enter Gear Description" required>
                        </div>

                        <div class="input-block">
                            <label for="price">Base Price</label>
                            <input type="number" id="price" name="price" placeholder="Enter Gear price" required>
                        </div>

                        <div class="input-block">
                            <label for="stock">Stock</label>
                            <input type="number" id="stock" name="stock" placeholder="Enter Gear stock" required>
                        </div>

                        <div class="input-block">
                            <label for="category">Gear Category</label>
                            <select name="category" id="category" required>
                                <option value="" selected disabled style="background: #999; color: black;">Select Category</option>
                                <?php if(!empty($categories)) :?>
                                    <?php foreach($categories as $category) : ?>
                                    <option value="<?= esc($category['category_id']); ?>"><?= esc($category['category']); ?></option>
                                    <?php endforeach;?>
                                <?php else :?>
                                    <option value="" title="will set to null if there is no category" class="no">No categories available</option>
                                <?php endif;?>
                            </select>
                        </div>

                        <div class="input-block">
                            <label for="img">Gear Image</label>
                            <input type="file" id="img" name="img" placeholder="Select Img" required>
                        </div>

                        <div class="buttons">
                            <button type="submit">Add</button>
                            <button type="reset">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- MODAL FOR ADDING NEW GEAR CATEGORY -->
    <div id="categoriesModal" class="modal">
        <div class="modal-content">
            <div class="add">
                <span class="close close-categories"></span>
                <h2>Add Category</h2>
            </div>

            <div class="content">
                <form action="<?= base_url('/admin/gears/addCat') ?>" method="post">
                    <div class="input-block">
                        <label for="category">Category</label>
                        <input type="text" name="category" id="category" placeholder="Category">
                        <!-- ERROR MESSAGE -->
                        <?php if(session()->getFlashdata('catError')) :?>
                            <span style="color:darkred;"><?= esc(session()->get('catError')) ?></span>
                        <?php endif;?>
                    </div>

                    <div class="buttons">
                        <button type="submit">Add</button>
                        <button type="reset">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
        </main>
    </section>

    
	<script>
		document.addEventListener("DOMContentLoaded", function () {
			const notificationBell = document.getElementById("notificationBell");
			const notificationDropdown = document.getElementById("notificationDropdown");
			const notificationList = document.getElementById("notificationList");
			const notificationCount = document.getElementById("notificationCount");

			function fetchLowStockNotifications() {
				fetch("<?= base_url('/admin/notifications/low-stock') ?>")
					.then(response => response.json())
					.then(data => {
						notificationList.innerHTML = "";
						let count = data.length;

						if (count > 0) {
							notificationCount.textContent = count;
							notificationCount.style.display = "inline-block";
							data.forEach(item => {
								notificationList.innerHTML += `
									<li>
										⚠️ <b>${item.product_name}</b> is low on stock: ${item.stock_quantity} left!
									</li>`;
							});
						} else {
							notificationCount.style.display = "none";
							notificationList.innerHTML = `<li>No stock alerts</li>`;
						}
					});
			}

			notificationBell.addEventListener("click", () => {
				notificationDropdown.classList.toggle("hidden");
			});

			fetchLowStockNotifications();
			setInterval(fetchLowStockNotifications, 60000);
		});
	</script>
    
    <script src="<?= base_url('Admin/js/notifModal.js') ?>"></script>
	<script src="<?= base_url('Admin/js/dashboard1.js') ?>"></script>
    <script src="<?= base_url('Admin/js/management.js') ?>"></script>
</body>
</html>