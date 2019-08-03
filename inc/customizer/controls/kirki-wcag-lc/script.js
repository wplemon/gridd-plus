/* global wcagColors */
wp.customize.controlConstructor['kirki-wcag-lc'] = wp.customize.Control.extend({

	/**
	 * The selected hue.
	 *
	 * @since 1.0
	 * @var {int}
	 */
	hue: 0,

	/**
	 * An array of all colors for this hue.
	 *
	 * @since 1.0
	 * @var {Array}
	 */
	allColors: false,

	/**
	 * An object containing the accessible colors for AAA, AA & A compliance.
	 *
	 * @since 1.0
	 * @var {Object}
	 */
	colors: {},

	/**
	 * Triggered when the control is ready.
	 *
	 * @since 1.0
	 * @returns {void}
	 */
	ready: function() {
		var control      = this,
			currentValue = this.setting.get();

		// Set initial hue.
		this.setHue();

		// We use debounced methods to avoid over-calculating things.
		this.updateHTMLDebounced = _.debounce( _.bind( control.updateControlHTML, this ), 5 );

		// Get available colors. This is the initial run when the control gets init,
		// no reason to run the debounced method here.
		this.updateColors( false );

		// Check if we're on auto mode or custom mode.
		// If the selected color is one of the AAA or AA colors then we're on autopilot.
		this.isAuto = ( this.colors && ( -1 !== this.colors.AAA.indexOf( currentValue ) || 20 < this.colors.AA.indexOf( currentValue ) ) );

		// Init tabs.
		this.initTabs();

		// Init auto or custom mode depending on our selected color.
		if ( this.isAuto ) {
			control.destroyCustom();
			control.initAuto();
		} else {
			control.destroyAuto();
			control.initCustom();
		}
	},

	/**
	 * Init the tabs.
	 *
	 * @since 1.0
	 * @returns {void}
	 */
	initTabs: function() {
		var control      = this,
			autoButton   = control.container.find( '.tab-headers .trigger-auto' ),
			customButton = control.container.find( '.tab-headers .trigger-custom' );

		if ( control.isAuto ) {
			autoButton.addClass( 'active' );
		} else {
			customButton.addClass( 'active' );
		}

		autoButton.on( 'click', function( e ) {
			e.preventDefault();
			customButton.removeClass( 'active' );
			autoButton.addClass( 'active' );
			control.destroyCustom();
			control.initAuto();
		});

		customButton.on( 'click', function( e ) {
			e.preventDefault();
			autoButton.removeClass( 'active' );
			customButton.addClass( 'active' );
			control.destroyAuto();
			control.initCustom();
		});
	},

	/**
	 * Init functionality for auto.
	 *
	 * @since 1.0
	 * @returns {Object} - this
	 */
	initAuto: function() {
		var control = this;
		this.isAuto = true;

		// Set the hue.
		control.setHue();

		// Update Colors.
		this.updateColors( false );

		// Show the Auto container.
		this.container.find( '.kirki-input-container.auto' ).show();

		// Add the input.
		this.container.find( '.color-hue-container' ).html( '<input class="color-hue" type="text" data-type="hue" value="' + this.hue + '" />' );

		// Init the colorpicker.
		this.initHuePicker();

		this.settingsWatchers = function() {

			// Watch for changes to the background color.
			control.watchSetting( control.params.choices.backgroundColor );

			// Watch for changes to the text color.
			control.watchSetting( control.params.choices.textColor );

			// Watch radio-inputs.
			control.radioInputListeners();
		};

		this.settingsWatchers();

		this.updateHTMLDebounced( true );

		// Expand color-selectors when requested.
		control.container.find( '.expand-selectors' ).on( 'click', function( e ) {
			e.preventDefault();
			control.container.find( '.rating-containers-wrapper' ).toggleClass( 'hidden' );
		});
	},

	/**
	 * Init functionality for custom.
	 *
	 * @since 1.0
	 * @returns {Object} - this
	 */
	initCustom: function() {
		this.isAuto = false;

		// Add the input field.
		this.container.find( '.color-hex-container' ).html( '<input class="color-hex" type="text" value="' + this.setting.get() + '" />' );

		// Show the Custom container.
		this.container.find( '.kirki-input-container.custom' ).show();

		// Init the colorpicker.
		this.initHexPicker();
	},

	/**
	 * Destroy the hue colorpicker and remove any listeners we have.
	 *
	 * @since 1.0
	 * @returns {Object} - this
	 */
	destroyAuto: function() {

		// Hide the Auto container.
		this.container.find( '.kirki-input-container.auto' ).hide();

		// Destroy the colorpicker.
		if ( this.container.find( '.auto .color-hue' ).wpColorPicker( 'instance' ) ) {
			this.container.find( '.auto .color-hue' ).wpColorPicker( 'destroy' );
		}

		// Remove the picker entirely.
		this.container.find( '.color-hue-container' ).html( '' );

		// Remove watchers added in the initAuto function.
		this.settingsWatchers = function() {};

		// Remove event watchers for the expand link.
		this.container.find( '.expand-selectors' ).off();
	},

	/**
	 * Destroy the hex colorpicker and any listeners we might have.
	 *
	 * @since 1.0
	 * @returns {Object} - this
	 */
	destroyCustom: function() {

		// Hide the Custom container.
		this.container.find( '.kirki-input-container.custom' ).hide();

		// Destroy the colorpicker.
		if ( this.container.find( '.custom .color-hex' ).wpColorPicker( 'instance' ) ) {
			this.container.find( '.custom .color-hex' ).wpColorPicker( 'destroy' );
		}

		// Remove the colorpicker entirely.
		this.container.find( '.color-hex-container' ).html( '' );
	},

	/**
	 * Init the hex colorpicker.
	 *
	 * @since 1.0
	 * @returns {void}
	 */
	initHexPicker: function() {
		var control   = this,
			hexPicker = control.container.find( '.custom .color-hex' );

		hexPicker.wpColorPicker({
			change: function() {

				// Small hack: the picker needs a small delay
				setTimeout( function() {

					// Save the value.
					control.setting.set( hexPicker.val() );
				}, 20 );
			}
		});
	},

	/**
	 * Initialize the hue colorpicker.
	 *
	 * @since 1.0
	 * @returns {void}
	 */
	initHuePicker: function() {
		var control   = this,
			huePicker = control.container.find( '.color-hue' );

		huePicker.attr( 'value', this.hue );
		huePicker.wpColorPicker({
			change: function() {

				// Small hack: the picker needs a small delay
				setTimeout( function() {

					// Set the hue.
					control.hue = parseInt( huePicker.val(), 10 );

					// Update colors.
					// This gets triggered with a small delay so there's no reason to run the debounced version.
					control.updateColors( true );
				}, 20 );
			}
		});
	},

	/**
	 * Set the hue in the control object as an integer.
	 * If no hue is defined it gets the saved value
	 *
	 * @param {int} hue
	 */
	setHue: function() {
		var color = this.setting.get();
		this.hue  = ( color ) ? wcagColors.getColorProperties( color ).h : 210;
	},

	/**
	 * Gets accessible colors accoring to their rating.
	 *
	 * @param {string} rating - Can be AAA, AA or A.
	 * @returns {Array}
	 */
	queryColors: function( rating ) {
		var backgroundMinContrast,
			surroundingTextMinContrast,
			backgroundColor      = wp.customize( this.params.choices.backgroundColor ).get(),
			backgroundColorProps = wcagColors.getColorProperties( backgroundColor );

		switch ( rating ) {
			case 'AAA':
				backgroundMinContrast      = 7;
				surroundingTextMinContrast = 3;
				break;
			case 'AA':
				backgroundMinContrast      = 4.5;
				surroundingTextMinContrast = 2;
				break;
			case 'A':
				backgroundMinContrast      = 3;
				surroundingTextMinContrast = 1;
				break;
		}

		if ( ! this.allColors ) {
			this.allColors = wcagColors.getAll({
				hue: this.hue,
				minHueDiff: 0,
				maxHueDiff: 3,
				stepDiff: 3,
				stepSaturation: 0.025,
				stepLightness: 0.025,
				minLightness: 0.5 < backgroundColorProps.l ? 0 : 0.5,
				maxLightness: 0.5 < backgroundColorProps.l ? 0.5 : 1
			});
		}

		return this.allColors.pluck({ // We want our color to have a minimum contrast of 7:1 with a white background.
			color: backgroundColor,
			minContrast: backgroundMinContrast
		}).pluck({ // We want our color to have a minimum contrast of 3:1 with surrounding black text.
			color: wp.customize( this.params.choices.textColor ).get(),
			minContrast: surroundingTextMinContrast
		})
		.sortBy( 's' ) // Sort colors by contrast.
		.getHexArray();
	},

	/**
	 * Updates the control.allColors and control.colors attributes.
	 *
	 * @since 1.0
	 * @param {bool} updateValue - Whether we should update the selection or not.
	 * @returns {void}
	 */
	updateColors: function( updateValue ) {
		var i;
		this.allColors  = false;
		this.colors     = {
			AAA: this.queryColors( 'AAA' ),
			AA: this.queryColors( 'AA' ),
			A: this.queryColors( 'A' )
		};

		// Remove duplicates from AA list.
		for ( i = 0; i < this.colors.AAA.length; i++ ) {
			this.colors.AA.splice( this.colors.AA.indexOf( this.colors.AAA[ i ] ), 1 );
		}
		this.updateHTMLDebounced( updateValue );
	},

	/**
	 * Updates the HTML in the control.
	 *
	 * @since 1.0
	 * @param {bool} updateValue - Whether we should update the selection or not.
	 * @returns {void}
	 */
	updateControlHTML: function( updateValue ) {
		var control = this,
			html;

		// AAA colors.
		if ( control.colors.AAA[0] ) {
			control.container.find( '.rating-container-AAA' ).removeClass( 'hidden' );
			html = '';
			_.each( control.colors.AAA, function( color ) {
				html += control.getChoiceMarkup( color );
			});
			control.container.find( '.rating-container-AAA .colors-container' ).html( html );
		} else {
			control.container.find( '.rating-container-AAA' ).addClass( 'hidden' );
		}

		// AA colors.
		if ( control.colors.AA[0] ) {
			control.container.find( '.rating-container-AA' ).removeClass( 'hidden' );
			html = '';
			_.each( control.colors.AA, function( color ) {
				html += control.getChoiceMarkup( color );
			});
			control.container.find( '.rating-container-AA .colors-container' ).html( html );
		} else {
			control.container.find( '.rating-container-AA' ).addClass( 'hidden' );
		}

		// A colors.
		if ( ! control.colors.AAA[0] && 20 > control.colors.AA.length && control.colors.A[0] ) {
			control.container.find( '.rating-container-A' ).removeClass( 'hidden' );
			html = '';
			_.each( control.colors.A, function( color ) {
				html += control.getChoiceMarkup( color );
			});
			control.container.find( '.rating-container-A .colors-container' ).html( html );
		} else {
			control.container.find( '.rating-container-A' ).addClass( 'hidden' );
		}

		if ( updateValue ) {

			// Auto-update the selected color.
			setTimeout( function() {
				if ( control.getBest() ) {
					control.container.find( 'input[value=' + control.getBest() + ']' ).attr( 'checked', true ).trigger( 'change' );
				}
			});
		}

		// Update the indicated color & rating.
		this.updateSelectedColorIndicators();

		// Regenerate listeners.
		this.radioInputListeners();
	},

	/**
	 * Gets the HTMl for a single color option. Used by the updateControlHTML() function.
	 *
	 * @param {string} color
	 * @returns {string}
	 */
	getChoiceMarkup: function( color ) {
		var control = this,
			html    = '';

		html += '<label>';
		html += '<input type="radio" value="' + color + '" name="_customize-kirki-wcag-lc-' + control.id + '"';
		html += ( control.setting.get() === color ) ? ' checked' : '';
		html += '/>';
		html += '<span class="a11y-text-selector-label" style="background-color:' + color + ';"></span>';
		html += '<span class="screen-reader-text">' + color + '</span>';
		html += '</label>';
		return html;
	},

	/**
	 * Watch defined controls and re-trigger results calculations when there's a change.
	 *
	 * @since 1.0
	 * @param {string} settingToWatch - The setting we're watching. This can either be the background or the text color.
	 * @returns {void}
	 */
	watchSetting: function( settingToWatch ) {
		var control = this;

		wp.customize( settingToWatch, function( setting ) {
			setting.bind( function() {
				control.updateColors( true );
			});
		});

		if ( -1 < settingToWatch.indexOf( '[' ) ) {
			wp.customize( settingToWatch.split( '[' )[0], function( setting ) {
				setting.bind( function() {
					control.updateColors( true );
				});
			});
		}
	},

	/**
	 * Get the best available color for a11y.
	 *
	 * @since 1.0
	 * @returns {string}
	 */
	getBest: function() {
		if ( this.colors.AAA[0] ) {
			return this.colors.AAA[0];
		}
		if ( this.colors.AA[0] ) {
			return this.colors.AA[0];
		}
		if ( this.colors.A[0] ) {
			return this.colors.A[0];
		}
	},

	/**
	 * Updates the indicators for selected color.
	 *
	 * @since 1.0
	 * @returns {void}
	 */
	updateSelectedColorIndicators: function() {
		var value  = this.setting.get(),
			rating = '';
		this.container.find( '.indicator .current-color' ).html( value );

		if ( -1 !== this.colors.AAA.indexOf( value ) ) {
			rating = ' - (AAA)';
		} else if ( -1 !== this.colors.AA.indexOf( value ) ) {
			rating = ' - (AA)';
		}

		if ( ! rating ) {
			this.container.find( '.indicator .current-color' ).html( '<del>' + value + '</del>' );
		}

		this.container.find( '.indicator .current-rating' ).html( rating );
	},

	/**
	 * Destroy listeners for radios and add them anew.
	 *
	 * @since 1.0
	 * @returns void
	 */
	radioInputListeners: function() {
		var control = this;

		this.container.find( 'input[type="radio"]' ).off().on( 'click change keyup', function() {
			var value = jQuery( this ).val();
			control.setting.set( value );
			control.container.find( '.hidden-value-hex' ).attr( 'value', value ).trigger( 'change' );
			control.isAuto = true;
			control.updateSelectedColorIndicators();
		});
	},

		/**
	 * Embed the control.
	 *
	 * Overrides the embed() method to do nothing,
	 * so that the control isn't embedded on load,
	 * unless the containing section is already expanded.
	 *
	 * @since 1.1.0
	 * @returns {void}
	 */
	embed: function() {
		var control   = this,
			sectionId = control.section();

		if ( ! sectionId ) {
			return;
		}
		wp.customize.section( sectionId, function( section ) {
			section.expanded.bind( function( expanded ) {
				if ( expanded ) {
					control.actuallyEmbed();
				}
			} );
		} );
	},

	/**
	 * Deferred embedding of control.
	 *
	 * This function is called in Section.onChangeExpanded() so the control
	 * will only get embedded when the Section is first expanded.
	 *
	 * @since 1.1.0
	 * @return {void}
	 */
	actuallyEmbed: function() {
		if ( 'resolved' === this.deferred.embedded.state() ) {
			return;
		}
		this.renderContent();
		this.deferred.embedded.resolve();
	}
});
