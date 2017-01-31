<template>
	<div id="app">
		<md-sidenav class="md-fixed main-sidebar" ref="leftSidenav">
      <div class="top-of-side-bar">
        <md-image :md-src="require('../assets/logo.png')" style="height:100px"></md-image>        
      </div>
      <div class="main-sidebar-links">
	      <md-list>
	  			<md-list-item>
			      <md-icon>move_to_inbox</md-icon> <span>Inbox</span>
			    </md-list-item>

			    <md-list-item>
			      <md-icon>send</md-icon> <span>Sent Mail</span>
			    </md-list-item>

			    <md-list-item>
			      <md-icon>delete</md-icon> <span>Trash</span>
			    </md-list-item>

			    <md-list-item>
			      <md-icon>whatshot</md-icon>
			      <span>News</span>

			      <md-list-expand>
			        <md-list>
			          <md-list-item class="md-inset">World</md-list-item>
			          <md-list-item class="md-inset">Americas</md-list-item>
			          <md-list-item class="md-inset">Europe</md-list-item>
			        </md-list>
			      </md-list-expand>
			    </md-list-item>

			    <md-list-item>
			      <md-icon>error</md-icon> <span>Spam</span>
			      <md-divider class="md-inset"></md-divider>
			    </md-list-item>

			    <md-list-item>
			      <md-avatar>
			        <img src="https://placeimg.com/40/40/people/5" alt="People">
			      </md-avatar>

			      <span>Abbey Christansen</span>

			      <md-button class="md-icon-button md-list-action">
			        <md-icon class="md-primary">chat_bubble</md-icon>
			      </md-button>
			    </md-list-item>
			  </md-list>
			</div>
	  </md-sidenav>

		<div class="page-content" ref="pageContent">
		  <md-toolbar class="top-bar">
			  <div class="md-toolbar-container">
			    <md-button class="md-icon-button" id="btn-toggle-sidebar" @click="toggleLeftSidenav">
			      <md-icon>menu</md-icon>
			    </md-button>

			    <span style="flex: 1;"></span>

			    <div class="dropdown user-dropdown">
				    <a href="#" class="dropdown-toggle user-link" data-toggle="dropdown" aria-expanded="true">
					  	<md-avatar class="user-avatar">
							  <img src="https://placeimg.com/40/40/people/5" alt="Avatar">
							</md-avatar>
							<span class="user-name">administrator</span>
						</a>
	          <ul class="dropdown-menu">
					    <li><a href="#">Logout</a></li>
					  </ul>
					 </div>
			  </div>
			</md-toolbar>
		  
		  <div class="main-content">
		    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quo, rerum? Error sunt, aperiam dolores, atque expedita molestiae tenetur. Quis eveniet accusamus velit explicabo adipisci reiciendis modi eaque quas, officia excepturi.</p>
		  </div>
	  </div>
	</div>
</template>

<script>
export default {
  methods: {
    toggleLeftSidenav() {
      this.$refs.leftSidenav.toggle();
      
      var el_page_ontent = this.$refs.pageContent;

      $(el_page_ontent).toggleClass('open-nav');
    }
  }
}
</script>

<style lang="scss">
body.md-theme-app{
	background-color: #ecf0f5 !important;
}

.page-content{
	margin-left: 0;
	transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);

	&.open-nav{
		margin-left: 280px
	}

	.main-content{
		padding: 15px;
		background-color: #ecf0f5;
	}
}

.main-sidebar{
	.md-sidenav-content{
		width: 280px;
		left: -280px;
		transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
		background-color: #222d32 !important;
		display: flex;
		flex-flow: column;
		overflow: hidden;

		.main-sidebar-links{
			flex: 1;
			overflow: auto;
		}

		.top-of-side-bar{
	    width: 100%;
	    min-height: 120px;
	    display: flex;
	    align-items: center;
	    justify-content: center;
	    background: #fff;
		}

		.md-theme-app.md-list .md-list-item-container{
			background-color: inherit;
		}

		.md-list-expand .md-list.md-theme-app{
			background-color: red;
		}
	}

	&.md-active{
		.md-sidenav-content{
			left: 0;
		}

		.md-sidenav-backdrop{
			display: none;
		}
	}

	.md-theme-app.md-list{
		background-color: #222d32;
		color: #fff;

		.md-list-item .md-icon{
			color: #fff;
		}
	}
}

#btn-toggle-sidebar{
	color: #fff;
}

.md-divider.md-inset{
	margin-left: 0;
}

.top-bar{
	.user-link{
		text-decoration: none !important;
		color: #fff !important;
		padding: 24px 10px;

		&:hover{
			background-color: rgba(0, 0, 0, 0.12);
		}
	}

	.user-dropdown{		
		.dropdown-menu{
			border-radius: 0;
			border: 1px solid rgba(0, 0, 0, 0.06);

			a{
				text-decoration: none;
				
				&:hover{
					background-color: rgba(0, 0, 0, 0.06);
				}
			}
		}
	}

	.user-avatar{
		margin: inherit;
	}

	.user-name{
		margin-left: 10px;
	}
}
</style>