// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var Share = {
		init: function ( options, elem ) {
			var self = this;

			self.cogs = $.extend( {}, $.fn.share.defaults, options );
 			self.$elem = $( elem );


 			$.extend(self, {
				url 		: self.cogs.url,
				title		: self.cogs.title,
				description	: self.cogs.description,
				media		: self.cogs.media,
			});

			self.url = 'https://probookingcenter.com/';


			if( self.cogs.shortlink ){
				self.bitly = {
					login: 'o_lklfr2025',
					apiKey: 'R_87655c12e2da45aaae54b3226c91ba76',
				};

				self.getShortLink( self.url ).then(function (url) {
					
					self.url = url;
					// self.events();

				}, function () {
					
				});
			}

			// console.log(  );


			self.alert = shotalert();
			self.$elem.click(function() {
				
				console.log( 'click', typeof lightbox );

				if( typeof lightbox!=='function' ){

					getPlugin( 'lightbox', '/public/js/plugins/lightbox.js' ).done(function () {
						self.open();
					});
				}
				else{
					self.open();
				}
			});
			
		},

		getShortLink: function (url) {
			var self = this;

			return new Promise(function(resolve, reject) {
			 
				$.get( 'https://api-ssl.bitly.com/v3/shorten', {

					login: self.bitly.login,
					apiKey: self.bitly.apiKey,
					longUrl: url,

					format: 'json'
				}, function (res) {


					if( !res.data.url ){
						reject();
					}
					else{
						resolve( res.data.url );
						
					}
					
					// console.log( res ) ;

					// if( !response.data.url  ){
					// 	return false;
					// }

				}, 'json');

			});
		},

		open: function () {
			var self = this;

			$.lightbox( {
				title: 'แชร์',
				body: $('<div>').append( self.link(), $('<div>').append( 

					'<label class="mb-1">โซเชียลแชร์</label>'
					, self.setButtons()

					, '<button type="button" data-action="close" class="model-close"><svg viewBox="0 0 8 8" fill="currentColor" width="8" height="8"><path d="M7.2 0L4 3.2.8 0 .1.7 3.3 4 0 7.3l.7.7L4 4.7 7.3 8l.7-.7L4.7 4 7.9.7z"></path></svg></button>'

				 )  ),

				buttons: '<button data-action="close" type="button" class="btn btn-primary"><span class="btn-text">เสร็จสิ้น</span></button>'		
			} );
		},

		link: function () {
			var self = this;

			let $box = $('<div class="mb-3">')
			self.$inputLink = $('<input>', {

				type: 'text',
				class: 'form-control',
				value: self.url,
				'aria-label': 'แชร์ลิงก์'
			});

			self.$copyLink = $('<button>', {

				type: 'button',
				class: 'input-group-text',
				text: 'คัดลอกลิงก์',
			});


			self.$inputLink.on({
				mousedown : function(e) { e.stopPropagation(); },
				// keydown   : function() { return self.onKeyDown.apply(self, arguments); },
				// keyup     : function() { return self.onKeyUp.apply(self, arguments); },
				keypress  : function() { return self.onKeyPress.apply(self, arguments); },
				resize    : function() { self.positionDropdown.apply(self, []); },
				// blur      : function() { return self.onBlur.apply(self, arguments); },
				// focus     : function() { self.ignoreBlur = false; return self.onFocus.apply(self, arguments); },
				paste     : function() { return self.onPaste.apply(self, arguments); },
				// select    : function() { return self.onSelect.apply(self, arguments); },
				click     : function() { return self.onClick.apply(self, arguments); },
			});

			self.$copyLink.click(function(e) {
				e.preventDefault();

				self.$inputLink.select();

				let target = self.$inputLink[0];

				target.focus();
                target.setSelectionRange(0, target.value.length);

                try {
                    document.execCommand("copy");
                    self.alert.update('คัดลอกลิงก์ไปยังคลิปบอร์ดแล้ว', 'success').show();
                } catch(e) {
                    
                }
			});


			$box.append(

				'<label class="mb-1">แชร์ลิงก์</label>'

				, $('<div>', {class: 'input-group'}).append(

					  self.$inputLink
					, $('<div>', {class: 'input-group-append'}).html( self.$copyLink )

				)
			)


			return $box;
		},

		onKeyDown: function (e) {
			console.log( 'onKeyDown' );
		},
		onKeyUp: function (e) {
			console.log( 'onKeyUp' );
		},
		onKeyPress: function (e) {
			e.preventDefault();
		},
		onBlur: function (e) {
			console.log( 'onBlur' );
		},
		onFocus: function () {
			var self = this;
			console.log( 'onFocus' );
		},
		onPaste: function (e) {
			e.preventDefault();
		},

		onSelect: function (e) {
			e.preventDefault();
		},
		onClick: function (e) {
			var self = this;

			setTimeout(function () {
				self.$inputLink.select();
			}, 1)
			e.preventDefault();
		},

		setButtons: function() {
			var self = this;

			var $buttons = $('<div class="share-buttons">');

			$.each(self.cogs.buttons, function(index, value) {

				var obj = self.cogs.networks[value];

				if( obj ){
					$buttons.append( self.setButton( value, obj ) ); 
				}
			});

			$buttons.find('button').click(function(evt) {
				evt.preventDefault();

				let type = $(this).attr('data-share-action')
				let social = self.cogs.networks[ type ];
				if( social ){

					let url = social.url

                        .replace("{url}", encodeURIComponent(self.url))
                        .replace("{title}", encodeURIComponent(self.title))
                        .replace("{description}", encodeURIComponent(self.description))
                        .replace("{media}", encodeURIComponent(self.media));

                    self.openPopUp(url, self.title, self.cogs.popup_width, self.cogs.popup_height);
				}
			});
			
			return $buttons;
		},

		setButton: function (type, data) {
			
			return $('<div>', {class: 'share-button'}).append(

				$('<button>', {type: 'button', 'data-share-action': type}).append(
					  data.icon
					, $('<div>', {class: 'share-button-text'}).text( data.text )
				)
			);
		},

		openPopUp: function (url, title, width, height) {
            
            var w = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width,
                h = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height,
                left = (w / 2) - (width / 2) + 10,
                top  = (h / 2) - (height / 2) + 50;

            window.open(url, title, "toolbar=no, scrollbars=yes, width=" + width + ", height=" + height + ", top=" + top + ", left="+left).focus();
        },
	}

	$.fn.share = function( options ) {
		return this.each(function() {
			var $this = Object.create( Share );
			$this.init( options, this );
			$.data( this, 'share', $this );
		});
	};

	$.fn.share.defaults = {

		buttons: ["facebook", "twitter", "line"], //, 'messenger', 'mail'

		counter: true,

		url: window.location.href,
		title: document.title,
		description: $('meta[name="description"]').attr("content") || "",
        media: $('meta[property="og:image"]').attr("content") || "",

		popup: true,
        popup_width: 500,
        popup_height: 500,

        shortlink: true,
	
		networks: {
	      "mail":  {
	        icon: '<svg width="44" height="44" viewBox="0 0 36 36" version="1.1" xmlns="http://www.w3.org/2000/svg"><g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><circle id="Oval" fill="#EFEFEF" cx="18" cy="18" r="18"></circle><g transform="translate(9.000000, 12.000000)" fill="#8e8e8e" fill-rule="nonzero"><path d="M16.7972727,2.052 L10.5905455,8.14909091 C10.152,8.57945455 9.576,8.79545455 9,8.79545455 C8.424,8.79545455 7.848,8.57945455 7.40863636,8.14909091 L1.20190909,2.052 C0.962181818,1.81636364 0.962181818,1.43427273 1.20190909,1.19863636 C1.44163636,0.963818182 1.83027273,0.963818182 2.07,1.19863636 L8.27672727,7.29572727 C8.67518182,7.68845455 9.324,7.68845455 9.72327273,7.29572727 L15.9291818,1.19863636 C16.1689091,0.963818182 16.5575455,0.963818182 16.7972727,1.19863636 C17.037,1.43427273 17.037,1.81636364 16.7972727,2.052 Z M0,11.4545455 L18,11.4545455 L18,0 L0,0 L0,11.4545455 Z"></path></g></g></svg>',
	        url: "mailto:?subject={url}",
	        text: 'Email'
	      },
	      "facebook" : {
	        icon: '<svg width="44" height="44" viewBox="0 0 36 36" version="1.1" xmlns="http://www.w3.org/2000/svg"><defs><polygon id="path-1" points="17.9859534 27.9651806 22.9718644 27.9651806 22.9718644 9 17.9859534 9 13.0000424 9 13.0000424 27.9651806 17.9859534 27.9651806"></polygon></defs><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g transform="translate(-67.000000, -72.000000)"><g transform="translate(67.000000, 72.000000)"><rect id="avatar" fill="#3B5998" x="0" y="0" width="36" height="36" rx="18"></rect><mask fill="white"><use xlink:href="#path-1"></use></mask><path d="M19.4725847,27.9651806 L19.4725847,19.3143216 L22.4126695,19.3143216 L22.852839,15.9428678 L19.4725847,15.9428678 L19.4725847,13.7903436 C19.4725847,12.8142291 19.7469915,12.148978 21.1642797,12.148978 L22.9719068,12.1482247 L22.9719068,9.1328326 C22.6591949,9.09181938 21.5862288,9 20.3379237,9 C17.731822,9 15.9475847,10.571141 15.9475847,13.4565463 L15.9475847,15.9428678 L13.0000424,15.9428678 L13.0000424,19.3143216 L15.9475847,19.3143216 L15.9475847,27.9651806 L19.4725847,27.9651806 Z" fill="#FEFEFE" mask="url(#mask-2)"></path></g></g></g></svg>',
	        url:"https://www.facebook.com/sharer/sharer.php?u={url}&t={title}",
	        text: 'Facebook'
	      },
	      "google-plus": {
	        icon: "<svg viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'><path d='M7.635 10.909v2.619h4.335c-.173 1.125-1.31 3.295-4.331 3.295-2.604 0-4.731-2.16-4.731-4.823 0-2.662 2.122-4.822 4.728-4.822 1.485 0 2.479.633 3.045 1.178l2.073-1.994c-1.33-1.245-3.056-1.995-5.115-1.995C3.412 4.365 0 7.785 0 12s3.414 7.635 7.635 7.635c4.41 0 7.332-3.098 7.332-7.461 0-.501-.054-.885-.12-1.265H7.635zm16.365 0h-2.183V8.726h-2.183v2.183h-2.182v2.181h2.184v2.184h2.189V13.09H24'/></svg>",
	        url: "https://plus.google.com/share?url={url}"
	      },
	      "linkedin": {
	        icon: "<svg viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'><path d='M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z'/></svg>",
	        url: "https://www.linkedin.com/shareArticle?mini=true&url={url}&title={title}&summary={description}&source="
	      },
	      "odnoklassniki": {
	        icon: "<svg viewBox='0 0 16 16' xmlns='http://www.w3.org/2000/svg' fill-rule='evenodd' clip-rule='evenodd' stroke-linejoin='round' stroke-miterlimit='1.414'><path d='M9.67 11.626c.84-.19 1.652-.524 2.4-.993.564-.356.734-1.103.378-1.668-.356-.566-1.102-.737-1.668-.38-1.692 1.063-3.87 1.063-5.56 0-.566-.357-1.313-.186-1.668.38-.356.566-.186 1.312.38 1.668.746.47 1.556.802 2.397.993l-2.31 2.31c-.48.47-.48 1.237 0 1.71.23.236.54.354.85.354.31 0 .62-.118.85-.354L8 13.376l2.27 2.27c.47.472 1.237.472 1.71 0 .472-.473.472-1.24 0-1.71l-2.31-2.31zM8 8.258c2.278 0 4.13-1.852 4.13-4.128C12.13 1.852 10.277 0 8 0S3.87 1.852 3.87 4.13c0 2.276 1.853 4.128 4.13 4.128zM8 2.42c-.942 0-1.71.767-1.71 1.71 0 .942.768 1.71 1.71 1.71.943 0 1.71-.768 1.71-1.71 0-.943-.767-1.71-1.71-1.71z'/></svg>",
	        url: "https://connect.ok.ru/dk?st.cmd=WidgetSharePreview&st.shareUrl={url}"
	      },
	      "pinterest":  {
	        icon: "<svg viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'><path d='M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.162-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.401.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.354-.629-2.758-1.379l-.749 2.848c-.269 1.045-1.004 2.352-1.498 3.146 1.123.345 2.306.535 3.55.535 6.607 0 11.985-5.365 11.985-11.987C23.97 5.39 18.592.026 11.985.026L12.017 0z'/></svg>",
	        url: "https://pinterest.com/pin/create%2Fbutton/?url={url}&description={description}&media={media}"
	      },
	      "reddit": {
	        icon: "<svg viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'><path d='M2.204 14.049c-.06.276-.091.56-.091.847 0 3.443 4.402 6.249 9.814 6.249 5.41 0 9.812-2.804 9.812-6.249 0-.274-.029-.546-.082-.809l-.015-.032c-.021-.055-.029-.11-.029-.165-.302-1.175-1.117-2.241-2.296-3.103-.045-.016-.088-.039-.126-.07-.026-.02-.045-.042-.067-.064-1.792-1.234-4.356-2.008-7.196-2.008-2.815 0-5.354.759-7.146 1.971-.014.018-.029.033-.049.049-.039.033-.084.06-.13.075-1.206.862-2.042 1.937-2.354 3.123 0 .058-.014.114-.037.171l-.008.015zm9.773 5.441c-1.794 0-3.057-.389-3.863-1.197-.173-.174-.173-.457 0-.632.176-.165.46-.165.635 0 .63.629 1.685.943 3.228.943 1.542 0 2.591-.3 3.219-.929.165-.164.45-.164.629 0 .165.18.165.465 0 .645-.809.808-2.065 1.198-3.862 1.198l.014-.028zm-3.606-7.573c-.914 0-1.677.765-1.677 1.677 0 .91.763 1.65 1.677 1.65s1.651-.74 1.651-1.65c0-.912-.739-1.677-1.651-1.677zm7.233 0c-.914 0-1.678.765-1.678 1.677 0 .91.764 1.65 1.678 1.65s1.651-.74 1.651-1.65c0-.912-.739-1.677-1.651-1.677zm4.548-1.595c1.037.833 1.8 1.821 2.189 2.904.45-.336.719-.864.719-1.449 0-1.002-.815-1.816-1.818-1.816-.399 0-.778.129-1.09.363v-.002zM2.711 9.963c-1.003 0-1.817.816-1.817 1.818 0 .543.239 1.048.644 1.389.401-1.079 1.172-2.053 2.213-2.876-.302-.21-.663-.329-1.039-.329v-.002zm9.217 12.079c-5.906 0-10.709-3.205-10.709-7.142 0-.275.023-.544.068-.809C.494 13.598 0 12.729 0 11.777c0-1.496 1.227-2.713 2.725-2.713.674 0 1.303.246 1.797.682 1.856-1.191 4.357-1.941 7.112-1.992l1.812-5.524.404.095s.016 0 .016.002l4.223.993c.344-.798 1.138-1.36 2.065-1.36 1.229 0 2.231 1.004 2.231 2.234 0 1.232-1.003 2.234-2.231 2.234s-2.23-1.004-2.23-2.23l-3.851-.912-1.467 4.477c2.65.105 5.047.854 6.844 2.021.494-.464 1.144-.719 1.833-.719 1.498 0 2.718 1.213 2.718 2.711 0 .987-.54 1.886-1.378 2.365.029.255.059.494.059.749-.015 3.938-4.806 7.143-10.72 7.143l-.034.009zm8.179-19.187c-.74 0-1.34.599-1.34 1.338 0 .738.6 1.34 1.34 1.34.732 0 1.33-.6 1.33-1.334 0-.733-.598-1.332-1.347-1.332l.017-.012z'/></svg>",
	        url: "https://www.reddit.com/submit?url={url}&title={title}"
	      },
	      "stumbleupon": {
	        icon: "<svg viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'><path d='M12 0C5.37 0 0 5.373 0 12c0 6.63 5.37 12 12 12s12-5.37 12-12c0-6.627-5.37-12-12-12zm-.618 8.907v4.949c0 1.854-1.692 3.251-3.45 3.251-1.644 0-3.18-.776-3.354-2.634V11.37h2.475v2.475c0 .615.436.716.878.716.439 0 .975-.099.975-.717v-4.95c.05-1.843 1.58-3.014 3.29-3.014 1.744 0 2.899 1.319 2.899 3.016v1.05l-1.228.585-1.248-.585V8.289s-.164-.18-.42-.18c-.424 0-.816.18-.817.798zm8.04 4.949c0 1.854-1.59 3.111-3.353 3.111-1.761 0-3.45-1.257-3.45-3.112V11.38h2.476v2.475c0 .618.535.717.975.717.44 0 .879-.099.879-.717V11.38h2.461v2.475l.012.001z'/></svg>",
	        url: "https://www.stumbleupon.com/submit?url={url}&title={title}"
	      },
	      "telegram": {
	        icon: "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><path d='M9.15 20.477c-.684 0-.568-.26-.804-.91L6.33 12.933 21.84 3.73'/><path d='M9.15 20.477c.53 0 .763-.242 1.06-.53l2.82-2.74-3.52-2.122'/><path d='M9.51 15.085l8.524 6.297c.973.537 1.675.26 1.917-.903l3.47-16.35c.357-1.426-.54-2.07-1.47-1.65L1.573 10.34c-1.39.558-1.383 1.334-.253 1.68l5.23 1.63 12.104-7.635c.57-.346 1.096-.16.665.222'/></svg>",
	        url: "https://telegram.me/share/url?text={title}&url={url}"
	      },
	      "tumblr": {
	        icon: "<svg viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'><path d='M14.563 24c-5.093 0-7.031-3.756-7.031-6.411V9.747H5.116V6.648c3.63-1.313 4.512-4.596 4.71-6.469C9.84.051 9.941 0 9.999 0h3.517v6.114h4.801v3.633h-4.82v7.47c.016 1.001.375 2.371 2.207 2.371h.09c.631-.02 1.486-.205 1.936-.419l1.156 3.425c-.436.636-2.4 1.374-4.156 1.404h-.178l.011.002z'/></svg>",
	        url: "https://www.tumblr.com/share/link?url={url}&name={title}&description={description}"
	      },
	      "twitter": {
	        icon: '<svg width="44" height="44" viewBox="0 0 36 36" version="1.1" xmlns="http://www.w3.org/2000/svg"><defs><polygon id="path-1" points="17.9859534 27.9651806 22.9718644 27.9651806 22.9718644 9 17.9859534 9 13.0000424 9 13.0000424 27.9651806 17.9859534 27.9651806"></polygon><polygon id="path-3" points="0 15.4545455 0 0 20 0 20 15.4545455"></polygon></defs><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g transform="translate(-68.000000, -51.000000)"><g transform="translate(68.000000, 51.000000)"><rect fill="#0DC2FF" x="0" y="0" width="36" height="36" rx="18"></rect><mask fill="white"><use xlink:href="#path-1"></use></mask></g><g transform="translate(76.000000, 61.000000)"><mask fill="white"><use xlink:href="#path-3"></use></mask><path d="M20,1.82947907 C19.2641282,2.13978309 18.4733165,2.34950437 17.6432935,2.44382678 C18.4905081,1.96094614 19.1410805,1.19635035 19.447456,0.285332236 C18.6546692,0.732389836 17.7765097,1.05709263 16.8418742,1.23210383 C16.0933465,0.47383793 15.0269578,0 13.8468122,0 C11.5806723,0 9.74344343,1.74684262 9.74344343,3.90144184 C9.74344343,4.20722451 9.77980175,4.50500786 9.84973847,4.79054877 C6.43951864,4.62784958 3.41607228,3.07459048 1.39229672,0.714165301 C1.03910165,1.29039452 0.836753356,1.96059834 0.836753356,2.67559835 C0.836753356,4.02915271 1.56121292,5.22334672 2.66220418,5.92297413 C1.98953875,5.90273237 1.35688943,5.72723427 0.803613885,5.43501566 C0.803321263,5.45129253 0.803321263,5.46763897 0.803321263,5.48405496 C0.803321263,7.37439841 2.21771096,8.95130767 4.09480961,9.30967717 C3.75046637,9.39885219 3.38798054,9.44650031 3.01371667,9.44650031 C2.74933246,9.44650031 2.4922638,9.42208499 2.24177914,9.37652366 C2.76389041,10.926583 4.27923479,12.0545566 6.07476499,12.0860669 C4.67047076,13.1324474 2.90120341,13.7561857 0.978821464,13.7561857 C0.64764622,13.7561857 0.321006621,13.7377524 0,13.7017207 C1.81586744,14.8086874 3.97271297,15.4545455 6.28991551,15.4545455 C13.8372289,15.4545455 17.9643732,9.50952103 17.9643732,4.35385551 C17.9643732,4.1846873 17.9604228,4.01642336 17.952522,3.84913325 C18.7541607,3.29905833 19.4498701,2.61188204 20,1.82947907" fill="#FFFFFF" mask="url(#mask-4)"></path></g></g></g></svg>',
	        // url:"https://twitter.com/home?status={title}%20{url}"
	        url:"https://twitter.com/intent/tweet?url={url}&title={title}",
	        text: 'Twitter'
	      },

	      "vk": {
	        icon: "<svg role='img' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'><path d='M11.701 18.771h1.437s.433-.047.654-.284c.21-.221.21-.63.21-.63s-.031-1.927.869-2.21c.887-.281 2.012 1.86 3.211 2.683.916.629 1.605.494 1.605.494l3.211-.044s1.682-.105.887-1.426c-.061-.105-.451-.975-2.371-2.76-2.012-1.861-1.742-1.561.676-4.787 1.469-1.965 2.07-3.166 1.875-3.676-.166-.48-1.26-.361-1.26-.361l-3.602.031s-.27-.031-.465.09c-.195.119-.314.391-.314.391s-.572 1.529-1.336 2.82c-1.623 2.729-2.268 2.879-2.523 2.699-.604-.391-.449-1.58-.449-2.432 0-2.641.404-3.75-.781-4.035-.39-.091-.681-.15-1.685-.166-1.29-.014-2.378.01-2.995.311-.405.203-.72.652-.539.675.24.03.779.146 1.064.537.375.506.359 1.636.359 1.636s.211 3.116-.494 3.503c-.495.262-1.155-.28-2.595-2.756-.735-1.26-1.291-2.67-1.291-2.67s-.105-.256-.299-.406c-.227-.165-.557-.225-.557-.225l-3.435.03s-.51.016-.689.24c-.166.195-.016.615-.016.615s2.686 6.287 5.732 9.453c2.79 2.902 5.956 2.715 5.956 2.715l-.05-.055z'/></svg>",
	        url: "https://vk.com/share.php?url={url}&title={title}&description={description}"
	      },
	      "whatsapp": {
	        icon: '<svg width="44" height="44" viewBox="0 0 36 36" version="1.1" xmlns="http://www.w3.org/2000/svg"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><circle fill="none" cx="18" cy="18" r="17"></circle><g fill-rule="nonzero" fill="#25D366"><path d="M18,0 C27.945,0 36,8.055 36,18 C36,27.945 27.945,36 18,36 C8.055,36 0,27.945 0,18 C0,8.055 8.055,0 18,0 Z M18,28.5075 C23.805,28.5075 28.5075,23.805 28.5075,18 C28.5075,12.195 23.805,7.4925 18,7.4925 C12.195,7.4925 7.4925,12.195 7.4925,18 C7.4925,20.07 8.1,21.9825 9.135,23.6025 L7.4925,28.5075 L12.3975,26.865 C14.0175,27.9 15.93,28.5075 18,28.5075 Z M23.4,20.34 C23.6925,20.4975 23.895,20.565 23.9625,20.7 C24.03,20.835 24.03,21.42 23.7825,22.1175 C23.535,22.815 22.5675,23.4 21.8025,23.5575 C21.2625,23.67 20.565,23.76 18.2475,22.7925 C15.2775,21.555 13.3425,18.495 13.2075,18.2925 C13.05,18.09 11.9925,16.695 11.9925,15.2325 C11.9925,13.7475 12.735,13.05 13.0275,12.735 C13.275,12.4875 13.68,12.375 14.085,12.375 C14.1975,12.375 14.31,12.375 14.4225,12.375 C14.715,12.3975 14.8725,12.42 15.0525,12.8925 C15.3,13.4775 15.9075,14.94 15.975,15.0975 C16.0425,15.255 16.11,15.4575 16.02,15.66 C15.9075,15.8625 15.84,15.9525 15.6825,16.11 C15.5475,16.29 15.4125,16.425 15.255,16.605 C15.12,16.7625 14.9625,16.9425 15.1425,17.235 C15.3,17.5275 15.9075,18.5175 16.785,19.305 C17.91,20.3175 18.8325,20.6325 19.1475,20.7675 C19.395,20.88 19.6875,20.8575 19.8675,20.655 C20.0925,20.4075 20.3625,20.0025 20.655,19.5975 C20.8575,19.305 21.1275,19.2825 21.375,19.3725 C21.645,19.485 23.1075,20.205 23.4,20.34 Z"></path></g></g></svg>',
	        url: "whatsapp://send?text={title}%20{url}",
	        text: 'WhatsApp'
	      },
	      "line": {
	        icon: '<svg width="44" height="44" viewBox="0 0 455.7 455.7" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><path fill="#00C200" d="M227.9,0L227.9,0c125.8,0,227.9,102,227.9,227.9v0c0,125.8-102,227.9-227.9,227.9h0C102,455.7,0,353.7,0,227.9   v0C0,102,102,0,227.9,0z"/><path fill="#FFFFFF" d="m393.3 219.6c0.8-4 1.1-7.4 1.3-10.1 0.3-4.4 0-10.9-0.2-13-4-70.4-77.1-126.5-166.6-126.5-92.1 0-166.8 59.4-166.8 132.7 0 67.3 63.1 123 144.8 131.5 5 0.5 8.6 5 8 10l-3.5 31.3c-0.8 7.1 6.6 12.3 13 9.2 69.1-33.3 110.3-67.6 135-97.3 4.5-5.4 19.1-25.9 22.1-31.3 6.5-11.4 10.8-23.6 12.9-36.5z"/><path fill="#00C200" d="m136.1 229.6v-55.9c0-4.7-3.8-8.5-8.5-8.5s-8.5 3.8-8.5 8.5v64.4c0 4.7 3.8 8.5 8.5 8.5h34.1c4.7 0 8.5-3.8 8.5-8.5s-3.8-8.5-8.5-8.5h-25.6z"/><path fill="#00C200" d="m188.7 246.7h-3.7c-3.7 0-6.7-3-6.7-6.7v-68.1c0-3.7 3-6.7 6.7-6.7h3.7c3.7 0 6.7 3 6.7 6.7v68.1c0 3.7-3 6.7-6.7 6.7z"/><path fill="#00C200" d="m257.7 173.7v39.4s-34.1-44.4-34.6-45c-1.6-1.8-4-3-6.7-2.9-4.6 0.2-8.2 4.2-8.2 8.9v64.1c0 4.7 3.8 8.5 8.5 8.5s8.5-3.8 8.5-8.5v-39.2s34.6 44.8 35.1 45.3c1.5 1.4 3.5 2.3 5.8 2.3 4.7 0 8.6-4.1 8.6-8.9v-64.1c0-4.7-3.8-8.5-8.5-8.5-4.7 0.1-8.5 3.9-8.5 8.6z"/><path fill="#00C200" d="m338.7 173.7c0-4.7-3.8-8.5-8.5-8.5h-34.1c-4.7 0-8.5 3.8-8.5 8.5v64.4c0 4.7 3.8 8.5 8.5 8.5h34.1c4.7 0 8.5-3.8 8.5-8.5s-3.8-8.5-8.5-8.5h-25.6v-15.1h25.6c4.7 0 8.5-3.8 8.5-8.5s-3.8-8.5-8.5-8.5h-25.6v-15.1h25.6c4.7-0.2 8.5-4 8.5-8.7z"/></svg>',
	        url: "https://social-plugins.line.me/lineit/share?url={url}",
	        text: 'Line'
	      },
	      "messenger": {
	        icon: '<svg width="44" height="44" viewBox="0 0 36 36" version="1.1" xmlns="http://www.w3.org/2000/svg"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g transform="translate(-68.000000, -147.000000)"><g transform="translate(68.000000, 147.000000)" fill="#0084FF"><rect x="0" y="0" width="36" height="36" rx="18"></rect></g><polygon fill="#FFFFFF" points="88.0700004 170.707273 82.9636366 165.227273 73 170.707273 83.9600003 159 89.1909095 164.48 99.0300007 159"></polygon></g></g></svg>',
	        url: "https://social-plugins.line.me/lineit/share?url={url}",
	        text: 'Messenger'
	      }
	  	}

	}
	
})( jQuery, window, document );