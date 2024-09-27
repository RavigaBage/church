define(function () {
  var callMethod = {};

  callMethod.FilterSystem = (value, location) => {
    if (location == false) {
      var SearchItems = document.querySelectorAll(
        ".account .container_item .item"
      );
    } else {
      var SearchItems = document.querySelectorAll(".event .container_item .item");
    }


    DateList = [];
    nameList = [];
    FilterList = [];
    ConvertDates = [];
    SearchItems.forEach((element) => {
      DateList.push(
        element.querySelector(".item_name").getAttribute("data_item")
      );
      ElementName = element.querySelector(".item_name").innerHTML;
      SplitData = ElementName.split(' ');
      FirstName = SplitData[0];
      nameList.push(FirstName.toLocaleLowerCase());
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
        console.log(new Date(element_Date))
        Index = ConvertDates.indexOf(element_Date);
        SearchItems.forEach((element) => {
          if (
            element.querySelector(".item_name").getAttribute("data_item") ==
            DateList[Index]
          ) {
            FilterList.push(element);
          }
        });
      });
      CleanDate(FilterList.reverse());
    }

    if (value == "Descending") {
      NewList.reverse();
      NewList.forEach((element_Date) => {
        SearchItems.forEach((element) => {
          ElementName = element.querySelector(".item_name").innerHTML;
          SplitData = ElementName.split(' ');
          FirstName = SplitData[0].toLocaleLowerCase();
          if (element_Date == FirstName) {
            FilterList.push(element);
          }
        });
      });
      CleanDate(FilterList);
      CleanDate(FilterList);
    }

    if (value == "Year") {
    }

    if (value == "Ascending") {
      NewList.sort();
      NewList.forEach((element_Date) => {
        SearchItems.forEach((element) => {
          ElementName = element.querySelector(".item_name").innerHTML;
          SplitData = ElementName.split(' ');
          FirstName = SplitData[0].toLocaleLowerCase();
          if (element_Date == FirstName) {
            FilterList.push(element);
          }
        });
      });
      CleanDate(FilterList);
    }
    function CleanDate(value) {
      var Container_cover = "";
      if (location == false) {
        Container_cover = document.querySelector(
          ".account .container_item"
        );
      } else {
        Container_cover = document.querySelector(".event .container_item");
      }
    
      if (value.length > 0) {
        value.forEach((element) => {
          Container_cover.append(element);
        });
      }
    }
  };
  return callMethod;
});
