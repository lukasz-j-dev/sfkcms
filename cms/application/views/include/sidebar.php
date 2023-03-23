<?php if (!isset($cur_tab)) $cur_tab = $this->uri->segment(2)==''?'dashboard': $this->uri->segment(2); ?>
<?php if (!isset($sub_tab)) $sub_tab = $this->uri->segment(3)==''?'dashboard': $this->uri->segment(3); ?>

<!-- Left Sidebar -->
<aside id="leftsidebar" class="sidebar">  
  <!-- User Info -->
  <div class="user-info"> 
    <div class="image"> 
      <img src="<?= base_url()?>public/images/user.png" width="48" height="48" alt="User" />
    </div>
    <div class="info-container">
      <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= strtoupper($this->session->userdata('name'));?></div>
      <div class="email"><?= $this->session->userdata('email');?></div>
      <div class="btn-group user-helper-dropdown">
        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
        <ul class="dropdown-menu pull-right">
          <li id=""><a href="<?= base_url('admin/profile'); ?>"><i class="material-icons">person</i>Profile</a></li>
          <li role="seperator" class="divider"></li>
          <li id=""><a href="javascript:void(0);"><i class="material-icons">group</i>Followers</a></li>
          <li id=""><a href="javascript:void(0);"><i class="material-icons">shopping_cart</i>Sales</a></li>
          <li id=""><a href="javascript:void(0);"><i class="material-icons">favorite</i>Likes</a></li>
          <li role="seperator" class="divider"></li>
          <li id=""><a href="<?= base_url('auth/logout'); ?>"><i class="material-icons">input</i>Sign Out</a></li>
        </ul>
      </div>
    </div>
  </div>
  <!-- #User Info -->
  <!-- Menu -->
  <div class="menu">
    <ul class="list">
      <li class="header">MAIN NAVIGATION</li>
      <li id="dashboard">
        <a href="<?= base_url('admin/dashboard');?>">
          <i class="material-icons">home</i>
          <span>Home</span>
        </a>
      </li>
		<li id="pre-check">
			<a href="javascript:void(0);" class="menu-toggle">
				<i class="material-icons">playlist_add_check</i>
				<span>Pre Check</span>
			</a>
			<ul class="ml-menu">
				<li id="import">
					<a href="<?= base_url('admin/violations/import'); ?>">Import Violations</a>
				</li>
				<li id="exact_date">
					<a href="<?= base_url('admin/violations/duplicates_new/exact_date'); ?>">Duplicate Violation</a>
				</li>
				<li id="6hours">
					<a href="<?= base_url('admin/violations/duplicates_new/6hours'); ?>">Duplicate Violation (6h)</a>
				</li>
				<li id="images">
					<a href="<?= base_url('admin/violations/duplicatemedia_new/images'); ?>">Duplicate images</a>
				</li>
				<li id="videos">
					<a href="<?= base_url('admin/violations/duplicatemedia_new/videos'); ?>">Duplicate videos</a>
				</li>
				<li>
					<a href="#">Missing value</a>
				</li>
			</ul>
		</li>
		<li id="video-review">
			<a href="#">
				<i class="material-icons">camera_alt</i>
				<span>Video Review</span>
			</a>
		</li>
		<li id="plate-review">
			<a href="javascript:void(0);" class="menu-toggle">
				<i class="material-icons">rate_review</i>
				<span>Plate Review</span>
			</a>
			<ul class="ml-menu">
				<li>
					<a href="#">Missing DMV status</a>
				</li>
				<li>
					<a href="#">DMV contact not found</a>
				</li>
			</ul>
		</li>
		<li id="users">
        <a href="javascript:void(0);" class="menu-toggle">
          <i class="material-icons">person</i>
          <span>Users</span>
        </a>
        <ul class="ml-menu">
          <li id="add">
            <a href="<?= base_url('admin/users/add'); ?>">Add New User</a>
          </li>
          <li id="user_list">
            <a href="<?= base_url('admin/users'); ?>">Users List</a>
          </li>
          <li id="group">
            <a href="<?= base_url('admin/group'); ?>">User Group</a>
          </li>
          <li id="profile">
            <a href="<?= base_url('admin/profile'); ?>">User Profile</a>
          </li>
        </ul>
      </li>		
		<li id="violations">
			<a href="javascript:void(0);" class="menu-toggle">		
				<i class="material-icons">person</i>
				<span>Violations</span>	
			</a>
			<ul class="ml-menu">
			<?php /*	<li id="add_violation">
					<a href="<?= base_url('admin/violations/add'); ?>">Add Violation</a>
				</li> */ ?>
				<?php /* <li id="violation_list">
					<a href="<?= base_url('admin/violations'); ?>">Violations List</a>
				</li> */ ?>
				<li id="violation_list">
					<a href="<?= base_url('admin/violations/all'); ?>">All Violations</a>
				</li>
				<li id="violation_list">
					<a href="<?= base_url('admin/violations/missingmedia'); ?>">Missing Media</a>
				</li>
        <li id="violation_list">
					<a href="<?= base_url('admin/violations/missingvideo'); ?>">Missing Video</a>
				</li>
        <li id="violation_list">
          <a href="javascript:void(0);" class="menu-toggle toggled">		
            <span style="margin-left: 0px;">New</span>
          </a>
          <ul class="ml-menu">
            <li>
              <a href="<?= base_url('admin/violations/new'); ?>">New</a> 
            </li>
			<li>
				<a href="<?= base_url('admin/violations/duplicates'); ?>">Duplicate Plates</a>
			</li>
            <li>
              <a href="<?= base_url('admin/violations/duplicatemedia'); ?>">Duplicate media</a>
            </li>
            <li>
              <a href="<?= base_url('admin/violations/prequalified'); ?>">Pre-qualified</a> 
            </li>
            <li>
              <a href="<?= base_url('admin/violations/multiviolations'); ?>">Multi violations</a> 
            </li>
            <li>
              <a href="<?= base_url('admin/violations/notmailedyet'); ?>">Not mailed yet</a> 
            </li>
            <li>
              <a href="<?= base_url('admin/violations/withinwarningperiod'); ?>">Within warning period</a> 
            </li>
          </ul>
        </li>
				<li id="violation_list">
					<a href="<?= base_url('admin/violations/reviewed'); ?>">Reviewed</a>
				</li>
				<li id="violation_list">
					<a href="<?= base_url('admin/violations/mailed'); ?>">Mailed</a>
				</li>
				<li id="violation_list">
					<a href="<?= base_url('admin/violations/disputed'); ?>">Disputed</a>
				</li>
				<li id="violation_list">
					<a href="<?= base_url('admin/violations/unpaid'); ?>">Unpaid</a>
				</li>
				<li id="violation_list">
					<a href="<?= base_url('admin/violations/paid'); ?>">Paid</a>
				</li>
        		<li id="violation_list">
					<a href="<?= base_url('admin/violations/pastdue'); ?>">Past due</a>
				</li>
				<li id="violation_list">
					<a href="<?= base_url('admin/violations/warning'); ?>">Warning</a>
				</li>
				<li id="violation_list">
					<a href="<?= base_url('admin/violations/dismissed'); ?>">Dismissed</a>
				</li>
					<li id="violation_list">
					<a href="<?= base_url('admin/violations/archived'); ?>">Archived</a>
				</li>
					<li id="violation_list">
					<a href="<?= base_url('admin/violations/demo'); ?>">Demo</a> 
				</li>
				
			</ul>
		</li>
		<li id="cameras">
			<a href="javascript:void(0);" class="menu-toggle">		
				<i class="material-icons">person</i>
				<span>Cameras</span>	
			</a>
			<ul class="ml-menu">
				<li id="add_camera">
					<a href="<?= base_url('admin/cameras/add'); ?>">Add Camera</a>
				</li>
				<li id="camera_list">
					<a href="<?= base_url('admin/cameras'); ?>">Cameras List</a>
				</li>
			</ul>
		</li>
		<li id="villages">
			<a href="javascript:void(0);" class="menu-toggle">		
				<i class="material-icons">person</i>
				<span>Villages</span>	
			</a>
			<ul class="ml-menu">
				<li id="add_village">
					<a href="<?= base_url('admin/villages/add'); ?>">Add Village</a>
				</li>
				<li id="village_list">
					<a href="<?= base_url('admin/villages'); ?>">Villages List</a>
				</li>
			</ul>
		</li>
		<li id="plates">
			<a href="javascript:void(0);" class="menu-toggle">		
				<i class="material-icons">person</i>
				<span>Plates</span>	
			</a>
			<ul class="ml-menu">
				<li id="add_camera">
					<a href="<?= base_url('admin/plates/add'); ?>">Add Plate</a>
				</li>
				<li id="camera_list">
					<a href="<?= base_url('admin/plates'); ?>">Plates List</a>
				</li>
			</ul>
		</li>
    <li id="mmc"> <!-- Shang -->
			<a href="javascript:void(0);" class="menu-toggle">		
				<i class="material-icons">person</i>
				<span>MMC</span>	
			</a>
			<ul class="ml-menu">
				<li id="add_camera">
					<a href="<?= base_url('admin/mmc/add'); ?>">Add MMC</a>
				</li>
				<li id="camera_list">
					<a href="<?= base_url('admin/mmc'); ?>">MMC List</a>
				</li>
			</ul>
		</li>
      <li id="ci_examples">
        <a href="javascript:void(0);" class="menu-toggle">
          <i class="material-icons">code</i>
          <span>CI Examples</span>
        </a>
        <ul class="ml-menu">
          <li id="simple_datatable">
            <a href="<?= base_url('admin/ci_examples/simple_datatable');?>">Simple Datatable</a>
          </li>
          <li id="ajax_datatable">
            <a href="<?= base_url('admin/ci_examples/ajax_datatable');?>">Ajax Datatable</a>
          </li>
          <li id="pagination">
            <a href="<?= base_url('admin/ci_examples/pagination');?>">Pagination Examples</a>
          </li>
          <li id="file_upload">
            <a href="<?= base_url('admin/ci_examples/file_upload');?>">File Upload</a>
          </li>
          <li id="multi_file_upload">
            <a href="<?= base_url('admin/ci_examples/multi_file_upload');?>">Multiple Files Upload</a>
          </li>
          <li id="location">
            <a href="<?= base_url('admin/ci_examples/location');?>">Locations</a>
          </li>
          <li id="charts">
            <a href="<?= base_url('admin/ci_examples/charts');?>">Dynamic Charts</a>
          </li>
          <li id="advance_search">
            <a href="<?= base_url('admin/ci_examples/advance_search');?>">Advance Search</a>
          </li>
        </ul>
      </li>
      <li id="location">
        <a href="javascript:void(0);" class="menu-toggle">
          <i class="material-icons">my_location</i>
          <span>Locations</span>
        </a>
        <ul class="ml-menu">
          <li id="country">
            <a href="<?= base_url('admin/location/country');?>">Country</a>
          </li>
          <li id="menu_state">
            <a href="<?= base_url('admin/location/state');?>">State</a>
          </li>
          <li id="menu_city">
            <a href="<?= base_url('admin/location/city');?>">City</a>
          </li>
        </ul>
      </li>
      <li id="activity">
        <a href="<?= base_url('admin/activity');?>">
          <i class="material-icons">flag</i>
          <span>Users Activity</span>
        </a>
      </li>
      <li id="export">
        <a href="<?= base_url('admin/export');?>">
          <i class="material-icons">backup</i>
          <span>Backup & Export</span>
        </a>
      </li>
       <li id="general_settings">
        <a href="<?= base_url('admin/general_settings');?>">
          <i class="material-icons">settings</i>
          <span>Settings</span>
        </a>
      </li>
      <li id="typography">
        <a href="<?= base_url('admin/typography');?>">
          <i class="material-icons">text_fields</i>
          <span>Typography</span>
        </a>
      </li>
      <li id="helper">
        <a href="<?= base_url('admin/helper');?>">
          <i class="material-icons">layers</i>
          <span>Helper Classes</span>
        </a>
      </li>
      <li id="widgets">
        <a href="javascript:void(0);" class="menu-toggle">
          <i class="material-icons">widgets</i>
          <span>Widgets</span>
        </a>
        <ul class="ml-menu">
          <li id="cards">
            <a href="javascript:void(0);" class="menu-toggle">
              <span>Cards</span>
            </a>
            <ul class="ml-menu">
              <li id="">
                <a href="<?= base_url('admin/widgets/basic');?>">Basic</a>
              </li>
              <li id="">
                <a href="<?= base_url('admin/widgets/colored');?>">Colored</a>
              </li>
              <li id="">
                <a href="<?= base_url('admin/widgets/no_header');?>">No Header</a>
              </li>
            </ul>
          </li>
          <li id="infobox">
            <a href="javascript:void(0);" class="menu-toggle">
              <span>Infobox</span>
            </a>
            <ul class="ml-menu">
              <li id="">
                <a href="<?= base_url('admin/widgets/infobox_1');?>">Infobox-1</a>
              </li>
              <li id="">
                <a href="<?= base_url('admin/widgets/infobox_2');?>">Infobox-2</a>
              </li>
              <li id="">
                <a href="<?= base_url('admin/widgets/infobox_3');?>">Infobox-3</a>
              </li>
              <li id="">
                <a href="<?= base_url('admin/widgets/infobox_4');?>">Infobox-4</a>
              </li>
              <li id="">
                <a href="<?= base_url('admin/widgets/infobox_5');?>">Infobox-5</a>
              </li>
            </ul>
          </li>
        </ul>
      </li>
      <li id="ui">
        <a href="javascript:void(0);" class="menu-toggle">
          <i class="material-icons">swap_calls</i>
          <span>User Interface (UI)</span>
        </a>
        <ul class="ml-menu">
          <li id="alerts">
            <a href="<?= base_url('admin/ui/alerts');?>">Alerts</a>
          </li>
          <li id="animations">
            <a href="<?= base_url('admin/ui/animations');?>">Animations</a>
          </li>
          <li id="badges">
            <a href="<?= base_url('admin/ui/badges');?>">Badges</a>
          </li>

          <li id="breadcrumbs">
            <a href="<?= base_url('admin/ui/breadcrumbs');?>">Breadcrumbs</a>
          </li>
          <li id="buttons">
            <a href="<?= base_url('admin/ui/buttons');?>">Buttons</a>
          </li>
          <li id="collapse">
            <a href="<?= base_url('admin/ui/collapse');?>">Collapse</a>
          </li>
          <li id="colors">
            <a href="<?= base_url('admin/ui/colors');?>">Colors</a>
          </li>
          <li id="dialogs">
            <a href="<?= base_url('admin/ui/dialogs');?>">Dialogs</a>
          </li>
          <li id="icons">
            <a href="<?= base_url('admin/ui/icons');?>">Icons</a>
          </li>
          <li id="labels">
            <a href="<?= base_url('admin/ui/labels');?>">Labels</a>
          </li>
          <li id="list_group">
            <a href="<?= base_url('admin/ui/list_group');?>">List Group</a>
          </li>
          <li id="media_object">
            <a href="<?= base_url('admin/ui/media_object');?>">Media Object</a>
          </li>
          <li id="modals">
            <a href="<?= base_url('admin/ui/modals');?>">Modals</a>
          </li>
          <li id="notifications">
            <a href="<?= base_url('admin/ui/notifications');?>">Notifications</a>
          </li>
          <li id="pagination">
            <a href="<?= base_url('admin/ui/pagination');?>">Pagination</a>
          </li>
          <li id="preloaders">
            <a href="<?= base_url('admin/ui/preloaders');?>">Preloaders</a>
          </li>
          <li id="progressbars">
            <a href="<?= base_url('admin/ui/progressbars');?>">Progress Bars</a>
          </li>
          <li id="range_sliders">
            <a href="<?= base_url('admin/ui/range_sliders');?>">Range Sliders</a>
          </li>
          <li id="sortable_nestable">
            <a href="<?= base_url('admin/ui/sortable_nestable');?>">Sortable & Nestable</a>
          </li>
          <li id="sortable_nestable">
            <a href="<?= base_url('admin/ui/sortable_nestable');?>">Tabs</a>
          </li>
          <li id="thumbnails">
            <a href="<?= base_url('admin/ui/thumbnails');?>">Thumbnails</a>
          </li>
          <li id="tooltips_popovers">
            <a href="<?= base_url('admin/ui/tooltips_popovers');?>">Tooltips & Popovers</a>
          </li>
          <li id="waves">
            <a href="<?= base_url('admin/ui/waves');?>">Waves</a>
          </li>
        </ul>
      </li>
      <li id="forms">
        <a href="javascript:void(0);" class="menu-toggle">
          <i class="material-icons">assignment</i>
          <span>Forms</span>
        </a>
        <ul class="ml-menu">
          <li id="basic">
            <a href="<?= base_url('admin/forms/basic');?>">Basic Form Elements</a>
          </li>
          <li id="advanced">
            <a href="<?= base_url('admin/forms/advanced');?>">Advanced Form Elements</a>
          </li>
          <li id="examples">
            <a href="<?= base_url('admin/forms/examples');?>">Form Examples</a>
          </li>
          <li id="validation">
            <a href="<?= base_url('admin/forms/validation');?>">Form Validation</a>
          </li>
          <li id="wizard">
            <a href="<?= base_url('admin/forms/wizard');?>">Form Wizard</a>
          </li>
          <li id="editors">
            <a href="<?= base_url('admin/forms/editors');?>">Editors</a>
          </li>
        </ul>
      </li>
      <li id="tables">
        <a href="javascript:void(0);" class="menu-toggle">
          <i class="material-icons">view_list</i>
          <span>Tables</span>
        </a>
        <ul class="ml-menu">
          <li id="normal">
            <a href="<?= base_url('admin/tables/normal');?>">Normal Tables</a>
          </li>
          <li id="jquery">
            <a href="<?= base_url('admin/tables/jquery');?>">Jquery Datatables</a>
          </li>
          <li id="editable">
            <a href="<?= base_url('admin/tables/editable');?>">Editable Tables</a>
          </li>
        </ul>
      </li>
      <li id="medias">
        <a href="javascript:void(0);" class="menu-toggle">
          <i class="material-icons">perm_media</i>
          <span>Medias</span>
        </a>
        <ul class="ml-menu">
          <li id="gallery">
            <a href="<?= base_url('admin/medias/gallery');?>">Image Gallery</a>
          </li>
          <li id="carousel">
            <a href="<?= base_url('admin/medias/carousel');?>">Carousel</a>
          </li>
        </ul>
      </li>
      <li id="charts">
        <a href="javascript:void(0);" class="menu-toggle">
          <i class="material-icons">pie_chart</i>
          <span>Charts</span>
        </a>
        <ul class="ml-menu">
          <li id="morris">
            <a href="<?= base_url('admin/charts/morris');?>">Morris</a>
          </li>
          <li id="flot">
            <a href="<?= base_url('admin/charts/flot');?>">Flot</a>
          </li>
          <li id="chartjs">
            <a href="<?= base_url('admin/charts/chartjs');?>">ChartJS</a>
          </li>
          <li id="sparkline">
            <a href="<?= base_url('admin/charts/sparkline');?>">Sparkline</a>
          </li>
          <li id="jquery_knob">
            <a href="<?= base_url('admin/charts/jquery_knob');?>">Jquery Knob</a>
          </li>
        </ul>
      </li>
      <li id="examples">
        <a href="javascript:void(0);" class="menu-toggle">
          <i class="material-icons">content_copy</i>
          <span>Example Pages</span>
        </a>
        <ul class="ml-menu">
          <li id="signin">
            <a href="<?= base_url('admin/examples/signin');?>">Sign In</a>
          </li>
          <li id="signup">
            <a href="<?= base_url('admin/examples/signup');?>">Sign Up</a>
          </li>
          <li id="forgot_password">
            <a href="<?= base_url('admin/examples/forgot_password');?>">Forgot Password</a>
          </li>
          <li id="blank">
            <a href="<?= base_url('admin/examples/blank');?>">Blank Page</a>
          </li>
          <li id="page_404">
            <a href="<?= base_url('admin/examples/page_404');?>">404 - Not Found</a>
          </li>
          <li id="page_500">
            <a href="<?= base_url('admin/examples/page_500');?>">500 - Server Error</a>
          </li>
        </ul>
      </li>
      <li id="maps">
        <a href="javascript:void(0);" class="menu-toggle">
          <i class="material-icons">map</i>
          <span>Maps</span>
        </a>
        <ul class="ml-menu">
          <li id="google">
            <a href="<?= base_url('admin/maps/google');?>">Google Map</a>
          </li>
          <li id="yandex">
            <a href="<?= base_url('admin/maps/yandex');?>">YandexMap</a>
          </li>
          <li id="jvector">
            <a href="<?= base_url('admin/maps/jvector');?>">jVectorMap</a>
          </li>
        </ul>
      </li>
      
      <li id="">
        <a href="javascript:void(0);" class="menu-toggle">
          <i class="material-icons">trending_down</i>
          <span>Multi Level Menu</span>
        </a>
        <ul class="ml-menu">
          <li id="">
            <a href="javascript:void(0);">
              <span>Menu Item</span>
            </a>
          </li>
          <li id="">
            <a href="javascript:void(0);">
              <span>Menu Item - 2</span>
            </a>
          </li>
          <li id="">
            <a href="javascript:void(0);" class="menu-toggle">
              <span>Level - 2</span>
            </a>
            <ul class="ml-menu">
              <li id="">
                <a href="javascript:void(0);">
                  <span>Menu Item</span>
                </a>
              </li>
              <li id="">
                <a href="javascript:void(0);" class="menu-toggle">
                  <span>Level - 3</span>
                </a>
                <ul class="ml-menu">
                  <li id="">
                    <a href="javascript:void(0);">
                      <span>Level - 4</span>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </li>
        </ul>
      </li>
      <li id="changelogs">
        <a href="<?= base_url('admin/changelogs'); ?>">
          <i class="material-icons">update</i>
          <span>Changelogs</span>
        </a>
      </li>
      <li class="header">LABELS</li>
      <li id="">
        <a href="javascript:void(0);">
          <i class="material-icons col-red">donut_large</i>
          <span>Important</span>
        </a>
      </li>
      <li id="">
        <a href="javascript:void(0);">
          <i class="material-icons col-amber">donut_large</i>
          <span>Warning</span>
        </a>
      </li>
      <li id="">
        <a href="javascript:void(0);">
          <i class="material-icons col-light-blue">donut_large</i>
          <span>Information</span>
        </a>
      </li>
    </ul>
  </div>
  <!-- #Menu -->
  <!-- Footer -->
  <div class="legal">
    <div class="copyright">
      <a href="javascript:void(0);"><?= $this->general_settings['copyright'] ?></a>.
    </div>
  </div>
  <!-- #Footer -->
</aside>
<!-- #END# Left Sidebar -->

<script>
  $("#<?= $cur_tab; ?>").addClass('active');
  $("#<?= $sub_tab; ?>").addClass('active');
</script>
