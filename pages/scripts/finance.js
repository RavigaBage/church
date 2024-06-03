define(function () {
  var callMethod = {};

  callMethod.FilterSystem = (value, location) => {
    if (location == false) {
      var SearchItems = document.querySelectorAll(
        ".account .container_item .item"
      );
    } else {
      var SearchItems = document.querySelectorAll(".container_item .item");
    }

    console.log(SearchItems, value);
    DateList = [];
    nameList = [];
    FilterList = [];
    ConvertDates = [];
    SearchItems.forEach((element) => {
      DateList.push(
        element.querySelector(".item_name").getAttribute("data_item")
      );
      nameList.push(element.querySelector(".item_name").innerHTML);
    });

    DateList.forEach((element_Date) => {
      ConvertDates.push(new Date(element_Date).getTime());
    });

    NewList = nameList.sort();
    if (value == "modified") {
      NewListDates = [];
      ConvertDates.forEach((element) => {
        NewListDates.push(element);
      });
      NewListDates.sort();
      NewListDates.forEach((element_Date) => {
        Index = ConvertDates.indexOf(element_Date);
        console.log(element_Date, Index);
        SearchItems.forEach((element) => {
          if (
            element.querySelector(".item_name").getAttribute("data_item") ==
            DateList[Index]
          ) {
            FilterList.push(element);
          }
        });
      });
      CleanDate(FilterList);
    }

    if (value == "Descending") {
      NewList.reverse();
      NewList.forEach((element_Date) => {
        SearchItems.forEach((element) => {
          if (element.querySelector(".item_name").innerHTML == element_Date) {
            FilterList.push(element);
          }
        });
      });
      CleanDate(FilterList);
    }

    if (value == "Year") {
    }

    if (value == "Ascending") {
      NewList.sort();
      NewList.forEach((element_Date) => {
        SearchItems.forEach((element) => {
          if (element.querySelector(".item_name").innerHTML == element_Date) {
            FilterList.push(element);
          }
        });
      });
      CleanDate(FilterList);
    }
    function CleanDate(value) {
      if (location == false) {
        var Container_cover = document.querySelector(
          ".account .container_item"
        );
      } else {
        const Container_cover = document.querySelector(".container_item");
      }

      if (value.length > 0) {
        Container_cover.innerHTML = "";
        value.forEach((element) => {
          Container_cover.append(element);
        });
      }
    }
  };
  return callMethod;
});
