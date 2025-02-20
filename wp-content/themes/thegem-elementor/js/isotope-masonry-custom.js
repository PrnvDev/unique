/*!
 * Masonry layout mode
 * sub-classes Masonry
 * http://masonry.desandro.com
 */

( function( window, factory ) {
  'use strict';
  // universal module definition
  if ( typeof define == 'function' && define.amd ) {
    // AMD
    define( [
        '../layout-mode',
        'masonry/masonry'
      ],
      factory );
  } else if ( typeof exports == 'object' ) {
    // CommonJS
    module.exports = factory(
      require('../layout-mode'),
      require('masonry-layout')
    );
  } else {
    // browser global
    factory(
      window.ThegemIsotope.LayoutMode,
      window.Masonry
    );
  }

}( window, function factory( LayoutMode, Masonry ) {
'use strict';

var $ = jQuery;

// -------------------------- helpers -------------------------- //

// extend objects
function extend( a, b ) {
  for ( var prop in b ) {
    a[ prop ] = b[ prop ];
  }
  return a;
}

// -------------------------- masonryDefinition -------------------------- //

  // create an Outlayer layout class
  var MasonryMode = LayoutMode.create('masonry-custom');

  // save on to these methods
  var _getElementOffset = MasonryMode.prototype._getElementOffset;
  var layout = MasonryMode.prototype.layout;
  var _getMeasurement = MasonryMode.prototype._getMeasurement;

  // sub-class Masonry
  extend( MasonryMode.prototype, Masonry.prototype );

  // set back, as it was overwritten by Masonry
  MasonryMode.prototype._getElementOffset = _getElementOffset;
  MasonryMode.prototype.layout = layout;
  MasonryMode.prototype._getMeasurement = _getMeasurement;

  var measureColumns = MasonryMode.prototype.measureColumns;
  MasonryMode.prototype.measureColumns = function() {
    // set items, used if measuring first item
    this.items = this.thegem_isotope.filteredItems;
    measureColumns.call( this );
  };

  // HACK copy over isOriginLeft/Top options
  var _manageStamp = MasonryMode.prototype._manageStamp;
  MasonryMode.prototype._manageStamp = function() {
    this.options.isOriginLeft = this.thegem_isotope.options.isOriginLeft;
    this.options.isOriginTop = this.thegem_isotope.options.isOriginTop;
    _manageStamp.apply( this, arguments );
  };

  function getStyle(elem) {
      return window.getComputedStyle ? getComputedStyle(elem, "") : elem.currentStyle;
  }

  MasonryMode.prototype.fix_images_height = function() {
      var self = this;
      var container = this.options.isFitWidth ? this.element.parentNode : this.element;
      var $set = $(container);
      if (!$(this.thegem_isotope.options.itemImageWrapperSelector, $set).length) return;

      var max_heigth = 0;
      var padding = parseFloat($(self.thegem_isotope.options.itemSelector, $set).first().css('padding-top'));
      var wrap_border = parseFloat($(self.thegem_isotope.options.itemSelector, $set).first().find('.wrap').css('border-width'));
      var wrap_padding = parseFloat($(self.thegem_isotope.options.itemSelector, $set).first().find('.wrap').css('padding-top'));

      $(self.thegem_isotope.options.itemSelector + ' ' + self.thegem_isotope.options.itemImageWrapperSelector, $set).css('height', '');
      $(self.thegem_isotope.options.itemSelector + ' ' + self.thegem_isotope.options.itemImageWrapperSelector + ' img', $set).css('height', '');

      var caption = 0;
      if (self.thegem_isotope.options.gridType === 'portfolio') {
          if ($(self.thegem_isotope.options.itemSelector, $set).first().find('.wrap > .caption').is(':visible')) {
              caption = parseInt($(self.thegem_isotope.options.itemSelector, $set).first().find('.wrap > .caption').outerHeight());
          }
      }

      var fix_caption = false;
      var $items = $(self.thegem_isotope.options.itemSelector, $set).not('.double-item-squared, .double-item-vertical, .double-item-horizontal');

      if ($items.length == 0) {
          $items = $(self.thegem_isotope.options.itemSelector, $set).not('.double-item-squared, .double-item-vertical');
      }

      if ($items.length == 0) {
          return;
      }

      $items.each(function() {
          var height = parseFloat(getStyle($(self.thegem_isotope.options.itemImageWrapperSelector, this)[0]).height);
          var diff = height - parseInt(height);

          if (isNaN(height)) {
              return;
          }

          if ( diff < 0.5 ) {
              height = parseInt(height);
          }

          if ( (height - parseInt(height)) > 0.5 ) {
              height = parseInt(height + 0.5);
              fix_caption = true;
          }

          if (height > max_heigth) {
              max_heigth = height;
          }
      });

      if (caption > 0 && fix_caption) {
          caption -= 1;
      }

      if (caption > 0 && $set.closest('.portfolio').hasClass('title-on-page')) {
          caption += 1;
      }

      $(self.thegem_isotope.options.itemImageWrapperSelector, $set).css('height', max_heigth);
      $(self.thegem_isotope.options.itemSelector + '.double-item:not(.double-item-horizontal) ' + self.thegem_isotope.options.itemImageWrapperSelector, $set).css('height', '');

      if (!max_heigth) {
          return;
      }

      var setWidth = $set.outerWidth();

      $(self.thegem_isotope.options.itemSelector + '.double-item-vertical' + ', ' + self.thegem_isotope.options.itemSelector + '.double-item-squared', $set).each(function() {
          var calc_height = 2 * (max_heigth + padding + wrap_border + wrap_padding) + caption;
          $(self.thegem_isotope.options.itemImageWrapperSelector, this).css('height', calc_height);
      });
  }

  MasonryMode.prototype.fixItemsCaptionHeight = function(rowsData) {
      var self = this,
        container = this.options.isFitWidth ? this.element.parentNode : this.element,
        $set = $(container);

      $(this.thegem_isotope.options.itemSelector + ' .wrap > .caption', $set).css('height', '');

      for (var index = 1; index <= rowsData.count; index++) {
          var maxCaptionHeight = 0;

          if (rowsData[ index ] === undefined || rowsData[ index ].items.length == 1) {
              continue;
          }

          var elements = [];
          for (var itemIndex = 0; itemIndex < rowsData[ index ].items.length; itemIndex++) {
              if (rowsData[ index ].items[ itemIndex ].rowSpan != rowsData[ index ].items[ itemIndex ].rowIndex) {
                  continue;
              }

              var $caption = $('.wrap > .caption', rowsData[ index ].items[ itemIndex ].item.element);

              if (!$caption.length) {
                  continue;
              }

              var captionHeight = $caption.outerHeight();

              elements.push({
                  caption: $caption,
                  height: captionHeight
              });

              if (captionHeight > maxCaptionHeight) {
                  maxCaptionHeight = captionHeight;
              }
          }

          for (var elIndex = 0; elIndex < elements.length; elIndex++) {
              if (elements[ elIndex ].height < maxCaptionHeight) {
                  elements[ elIndex ].caption.outerHeight(maxCaptionHeight);
              }
          }
      }
  };

  MasonryMode.prototype.getRowCaptionHeight = function(rowsData, rowIndex) {
      if (rowsData[ rowIndex ] !== undefined) {
          for (var itemIndex = 0; itemIndex < rowsData[ rowIndex ].items.length; itemIndex++) {
              if (
                  !rowsData[ rowIndex ].items[ itemIndex ].item.element.classList.contains('format-quote') &&
                  ((rowsData[ rowIndex ].items[ itemIndex ].rowSpan == 1 && rowsData[ rowIndex ].items[ itemIndex ].colSpan == 1) ||
                  rowsData[ rowIndex ].items[ itemIndex ].rowSpan == rowsData[ rowIndex ].items[ itemIndex ].rowIndex)
              ) {
                  return $('.wrap > .caption', rowsData[ rowIndex ].items[ itemIndex ].item.element).outerHeight();
              }
          }
      }

      return null;
  };

  MasonryMode.prototype.getRowMinImageHeight = function(rowsData, rowIndex) {
      var self = this;
      var minHeight = -1;

      if (rowsData[ rowIndex ] !== undefined) {
          for (var itemIndex = 0; itemIndex < rowsData[ rowIndex ].items.length; itemIndex++) {
              if (
                  (rowsData[ rowIndex ].items[ itemIndex ].rowSpan == 1 && rowsData[ rowIndex ].items[ itemIndex ].colSpan == 1) /*||
                  rowsData[ rowIndex ].items[ itemIndex ].rowSpan == rowsData[ rowIndex ].items[ itemIndex ].rowIndex*/
              ) {
                  var $element = $(rowsData[ rowIndex ].items[ itemIndex ].item.element);
                  var height = Math.round($(self.thegem_isotope.options.itemImageWrapperSelector, $element).height());

                  if (minHeight == -1 || height < minHeight) {
                      minHeight = height;
                  }
              }
          }
      }

      return minHeight != -1 ? minHeight : null;
  };

  MasonryMode.prototype.getRowDoubleMinImageHeight = function(rowsData, rowIndex) {
      var self = this;
      var minHeight = -1;

      if (rowsData[ rowIndex ] !== undefined) {
          for (var itemIndex = 0; itemIndex < rowsData[ rowIndex ].items.length; itemIndex++) {
              if (
                  (rowsData[ rowIndex ].items[ itemIndex ].rowSpan == 1 && rowsData[ rowIndex ].items[ itemIndex ].colSpan == 1) ||
                  rowsData[ rowIndex ].items[ itemIndex ].rowSpan != rowsData[ rowIndex ].items[ itemIndex ].rowIndex
              ) {
                  continue;
              }

              var $element = $(rowsData[ rowIndex ].items[ itemIndex ].item.element);
              var height = $(self.thegem_isotope.options.itemImageWrapperSelector, $element).height();

              if (minHeight == -1 || height < minHeight) {
                  minHeight = height;
              }
          }
      }

      return minHeight != -1 ? minHeight : null;
  };

  MasonryMode.prototype.fixItemsImageHeight = function(rowsData) {
      var self = this,
        container = this.options.isFitWidth ? this.element.parentNode : this.element,
        $set = $(container),
        padding = parseFloat($(self.thegem_isotope.options.itemSelector, $set).first().css('padding-top'));

      $(self.thegem_isotope.options.itemSelector + ' ' + self.thegem_isotope.options.itemImageWrapperSelector, $set).css('height', '');
      $(self.thegem_isotope.options.itemSelector + ' ' + self.thegem_isotope.options.itemImageWrapperSelector + ' img', $set).css('height', '');

      var $items = $(self.thegem_isotope.options.itemSelector, $set).not('.double-item-squared, .double-item-vertical, .double-item-horizontal');

      if ($items.length == 0) {
          $items = $(self.thegem_isotope.options.itemSelector, $set).not('.double-item-squared, .double-item-vertical');
      }

      if ($items.length == 0) {
          return;
      }

      var maxNormalImageHeight = 0;
      $items.each(function() {
          var height = parseFloat(getStyle($(self.thegem_isotope.options.itemImageWrapperSelector, this)[0]).height);
          var diff = height - parseInt(height);

          if (isNaN(height)) {
              return;
          }

          if ( diff < 0.5 ) {
              height = parseInt(height);
          }

          if ( (height - parseInt(height)) > 0.5 ) {
              height = parseInt(height + 0.5);
          }

          if (height > maxNormalImageHeight) {
              maxNormalImageHeight = height;
          }
      });

      if (!maxNormalImageHeight) {
          return;
      }

      for (var index = 1; index <= rowsData.count; index++) {
          if (rowsData[ index ] === undefined) {
              continue;
          }

          for (var itemIndex = 0; itemIndex < rowsData[ index ].items.length; itemIndex++) {

              var $element = $(rowsData[ index ].items[ itemIndex ].item.element);
              var height = $(self.thegem_isotope.options.itemImageWrapperSelector, $element).height();

              if ((rowsData[ index ].items[ itemIndex ].rowSpan == 1 && rowsData[ index ].items[ itemIndex ].colSpan == 1) || rowsData[ index ].items[ itemIndex ].rowSpan != rowsData[ index ].items[ itemIndex ].rowIndex) {
                  if ($(window).width() > 767 && (rowsData[ index ].items[ itemIndex ].rowSpan == 1 && rowsData[ index ].items[ itemIndex ].colSpan == 1)) {
                      $(self.thegem_isotope.options.itemImageWrapperSelector + ' img', $element).height(maxNormalImageHeight);
                  }
                  continue;
              }

              if (rowsData[ index ].items[ itemIndex ].rowSpan > 1) {
                  if (rowsData[ index ].items.length == 1) {
                      continue;
                  }

                  var captionHeight = this.getRowCaptionHeight(rowsData, index - 1);

                  var prevRowImageHeight = this.getRowMinImageHeight(rowsData, index - 1) || maxNormalImageHeight;
                  var currentRowImageHeight = this.getRowMinImageHeight(rowsData, index) || maxNormalImageHeight;

                  var calcHeight = 0;
                  if (captionHeight !== null) {
                      calcHeight = prevRowImageHeight + currentRowImageHeight + 2 * padding + captionHeight;
                  } else {
                      var minImageHeight = this.getRowDoubleMinImageHeight(rowsData, index);

                      if (height > minImageHeight) {
                          $(self.thegem_isotope.options.itemImageWrapperSelector, $element).height(minImageHeight);
                      }

                      continue;
                  }

                  if (height > calcHeight) {
                      $(self.thegem_isotope.options.itemImageWrapperSelector, $element).height(calcHeight);
                  } else if (height < calcHeight) {
                      if (rowsData[ index ].items[ itemIndex ].item.size.width < self.containerWidth) {
                          $(self.thegem_isotope.options.itemImageWrapperSelector + ' img', $element).height(calcHeight);
                      }
                  }
              } else if (rowsData[ index ].items[ itemIndex ].colSpan > 1) {
                  if (height > maxNormalImageHeight) {
                      $(self.thegem_isotope.options.itemImageWrapperSelector, $element).height(maxNormalImageHeight);
                  } else if (height < maxNormalImageHeight && $(window).width() > 767) {
                      $(self.thegem_isotope.options.itemImageWrapperSelector + ' img', $element).height(maxNormalImageHeight).width('auto');
                  }
              }
          }
      }
  };

  MasonryMode.prototype.fixQuoteItemsHeight = function(rowsData) {
      var self = this,
      container = this.options.isFitWidth ? this.element.parentNode : this.element,
      $set = $(container);

      $(self.thegem_isotope.options.itemSelector + '.format-quote ' + self.thegem_isotope.options.itemImageWrapperSelector + ' img', $set).css('height', '');

      for (var index = 1; index <= rowsData.count; index++) {
          if (rowsData[ index ] === undefined) {
              continue;
          }

          for (var itemIndex = 0; itemIndex < rowsData[ index ].items.length; itemIndex++) {
              var item = rowsData[ index ].items[itemIndex];

              if (item.item.element.classList.contains('format-quote')) {
                  console.log(item);
              }
          }
      }
  };

  MasonryMode.prototype.buildRowsData = function() {
      var rowsData = {
          count: 0
      };

      for (var i = 0; i < this.items.length; i++) {
          var item = this.items[i];

          item.getSize();
          var remainder = item.size.outerWidth % this.columnWidth;
          var mathMethod = remainder && remainder < 1 ? 'round' : 'ceil';
          var colSpan = Math[ mathMethod ]( item.size.outerWidth / this.columnWidth );
          colSpan = Math.min( colSpan, this.cols );

          var startRow = -1;
          for (var j = 1; j <= rowsData.count; j++) {
              if (rowsData[ j ] !== undefined && rowsData[ j ].used + colSpan <= this.cols) {
                  startRow = j;
                  break;
              }
          }
          if (startRow == -1) {
              startRow = rowsData.count + 1;
          }

          var rowSpan =  1;
          if (item.element.classList.contains('double-item-squared') || item.element.classList.contains('double-item-vertical')) {
              rowSpan = 2;
          }

          for (var rowIndex = 0; rowIndex < rowSpan; rowIndex++) {
              var insertRow = startRow + rowIndex;

              if (rowsData[ insertRow ] === undefined) {
                  rowsData[ insertRow ] = {
                      items: [],
                      used: 0
                  };
                  rowsData.count += 1;
              }

              rowsData[ insertRow ].items.push({
                  item: item,
                  colSpan: colSpan,
                  rowSpan: rowSpan,
                  rowIndex: rowIndex + 1
              });
              rowsData[ insertRow ].used += colSpan;
          }
      }

      return rowsData;
  };

  MasonryMode.prototype.itemsHasCaption = function() {
      if (!this.items.length) {
          return false;
      }

      for (var i = 0; i < this.items.length; i++) {
          var item = this.items[i];

          if (!item.element.classList.contains('format-quote') && $('.wrap > .caption', item.element).is(':visible')) {
              return true;
          }
      }

      return false;
  };

  var _resetLayout = MasonryMode.prototype._resetLayout;
  MasonryMode.prototype._resetLayout = function() {
      _resetLayout.apply( this, arguments );

      if (this.thegem_isotope.options.gridType == 'news' || this.thegem_isotope.options.fixCaption) {
          var rowsData = this.buildRowsData();
      }

      if (this.thegem_isotope.options.fixCaption) {
          this.fixItemsCaptionHeight(rowsData);
      }

      if (this.thegem_isotope.options.fixHeightDoubleItems) {
          if (this.thegem_isotope.options.gridType == 'news' && this.itemsHasCaption()) {
              this.fixItemsImageHeight(rowsData);
              this.fixQuoteItemsHeight(rowsData);
          } else {
              this.fix_images_height();
          }
      }

      _resetLayout.apply( this, arguments );
  };

  return MasonryMode;

}));
