(function($) {
  function SocmSubpages() {
    documentReady = function() {
      // bind the sort and expand button to click events
      $('.subpages-button-sort').click( selectElements );
      $('.subpages-button-expand').click( expandList );
    }

    expandList = function(event) {
      // get the current target
      $current = $(event.currentTarget);
      // ... find the closest item with children
      $container = $current.closest('.page_item_has_children');
      // ... and toggle the expand class
      $container.toggleClass('expanded');
    }

    selectElements = function(event) {
      // get the current target
      $current = $(event.currentTarget);
      // ... find the belonging ul element
      $container = $current.next('ul');
      // ... get all the li elements list directly under the ul element and return as an `Array`
      $elements = $container.find('> li').get();
      // check if the current node is current sorted as ascending
      isAscending = $current.hasClass('subpages-sortorder-asc');
      // toggle the sort order class
      $current.toggleClass('subpages-sortorder-asc');

      // do the sorting
      $elements.sort(function(a, b) {
        // sorts differently depending if it should be ascending or descending
        if(isAscending) {
          if(a.innerText < b.innerText) return -1;
          if(a.innerText > b.innerText) return 1;
        } else {
          if(a.innerText < b.innerText) return 1;
          if(a.innerText > b.innerText) return -1;
        }

        return 0;
      });

      // repopulate the elements after being sorted
      $.each($elements, function(i, li) {
        $container.append(li);
      });
    }

    // everything starts here...
    $('document').ready(documentReady);
  }

  new SocmSubpages();
})(jQuery);