import static com.kms.katalon.core.checkpoint.CheckpointFactory.findCheckpoint
import static com.kms.katalon.core.testcase.TestCaseFactory.findTestCase
import static com.kms.katalon.core.testdata.TestDataFactory.findTestData
import static com.kms.katalon.core.testobject.ObjectRepository.findTestObject
import com.kms.katalon.core.checkpoint.Checkpoint as Checkpoint
import com.kms.katalon.core.cucumber.keyword.CucumberBuiltinKeywords as CucumberKW
import com.kms.katalon.core.mobile.keyword.MobileBuiltInKeywords as Mobile
import com.kms.katalon.core.model.FailureHandling as FailureHandling

import plp.CountProducts
import plp.Resources
import org.testng.Assert
import com.kms.katalon.core.testcase.TestCase as TestCase
import com.kms.katalon.core.testdata.TestData as TestData
import com.kms.katalon.core.testobject.TestObject as TestObject
import com.kms.katalon.core.webservice.keyword.WSBuiltInKeywords as WS
import com.kms.katalon.core.webui.keyword.WebUiBuiltInKeywords as WebUI
import internal.GlobalVariable as GlobalVariable


//@Author : Amit Baghel.

int i=3;


//boolean result=Resources.selectCityPopup();
//
//Assert.assertFalse(result);

//Moving the mouse cursor to the Header of the Page.
WebUI.mouseOver(findTestObject("Object Repository/PLPpage/PLP_Title"));

WebUI.waitForElementNotPresent(findTestObject("Object Repository/PLPpage/EMIHightoLow"), 5)

WebUI.click(findTestObject("Object Repository/PLPpage/EMIHightoLow"));

Thread.sleep(2000);

CountProducts count=new CountProducts();

int totalProductCount=Resources.getTotalCount();

//Calling the Lazy Load Function to load all the Products.
boolean flag=Resources.verifyLoadCount(i, totalProductCount, count);

//Now the Method in resources to get all the EMI count.
List<String> emi=new ArrayList<>();

//Adding all the EMI prices of the Product to the emi ArrayList.
emi.addAll(Resources.getallEMIValues(i,Resources.getTotalCount()));

for(int j=0;j<emi.size()-1;j++){
	int k=j+1;
	if(emi.get(j)>=emi.get(k)){
		continue;
	}else{
	Assert.assertFalse(true);
	}
	
}





























//WebUI.click(findTestObject("Object Repository/FilterButtons/ClearAllButton"))
//
//Thread.sleep(3000)
//
//WebUI.click(findTestObject('Object Repository/SortPage/p_Sort'))
//
//Thread.sleep(2000)
//
//WebUI.click(findTestObject('Object Repository/SortPage/input_EMI Amount (Low to High)_sort'))
//
//WebUI.click(findTestObject('Object Repository/SortPage/button_Apply'))
//
//int totalProducts=Resources.getTotalCount();
//
//int previous,i;
//
//for(i=1;i<=totalProducts;i++){
//	String emi=WebUI.getText(findTestObject("Object Repository/FilterButtons/EMIOfProduct"))
//	String[] emiValues=emi.split("\\.");
//	emiValues[1]=emiValues[1].replace(',','');
//	int currentValue=Integer.parseInt(emiValues[1]);
//	if(i==1){
//		previous=currentValue;
//		continue;
//	}else{
//	    if(previous>=currentValue){
//			continue;
//		}else{
//		  break;
//		}
//	}
//	
//}
//
//println(totalProducts + " :"+ i );
