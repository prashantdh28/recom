class KTLayout {
	static _isSidebarCollapse() {
		console.log('implemented');
		return document.body.classList.contains('sidebar-collapse');
	}

	static _handleMegaMenu() {
		const megaMenuEl = document.querySelector('#mega_menu');
		if (!megaMenuEl) return;

		const menu = KTMenu.getInstance(megaMenuEl);
		menu.toggle();

		setTimeout(() => {
			menu.toggle();
		}, 500);
	}

	static _handleSidebar() {
		const sidebarToggle = KTToggle.getInstance(this.sidebarToggleEl);
		sidebarToggle?.on('toggle', () => {
			this.sidebarEl.classList.add('animating');
			console.log('sidebar element after add animating', this.sidebarEl);

			this._handleMegaMenu();

			KTDom.transitionEnd(this.sidebarEl, () => {
				console.log('sidebar element after remove animating', this.sidebarEl);
				this.sidebarEl.classList.remove('animating');
			});
		});
	}

	static _handleSidebarMenu() {
		const menuEl = document.querySelector('#sidebar_menu');
		const scrollableEl = document.querySelector('#sidebar_scrollable');
		const menuActiveItemEl = menuEl.querySelector(".menu-item.active");

		if (!menuActiveItemEl || KTDom.isVisibleInParent(menuActiveItemEl, scrollableEl)) {
			return;
		}

		scrollableEl.scroll({
			top: KTDom.getRelativeTopPosition(menuActiveItemEl, scrollableEl) - 100,
			behavior: 'instant'
		});
	}

	static init() {
		this.sidebarEl = document.querySelector('#sidebar');
		this.sidebarWrapperEl = document.querySelector('#sidebar_wrapper');
		this.headerEl = document.querySelector('#header');
		this.sidebarToggleEl = document.querySelector('#sidebar_toggle');

		if (this.sidebarEl && this.sidebarToggleEl) {
			this._handleSidebar();
			this._handleSidebarMenu();
		}
	}

	static isSidebarCollapse() {
		return this._isSidebarCollapse();
	}
}

KTDom.ready(() => {
	KTLayout.init();
});

export default KTLayout;