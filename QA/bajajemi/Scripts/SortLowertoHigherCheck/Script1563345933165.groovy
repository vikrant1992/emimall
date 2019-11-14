import static com.kms.katalon.core.checkpoint.CheckpointFactory.findCheckpoint
import static com.kms.katalon.core.testcase.TestCaseFactory.findTestCase
import static com.kms.katalon.core.testdata.TestDataFactory.findTestData
import static com.kms.katalon.core.testobject.ObjectRepository.findTestObject
import com.kms.katalon.core.checkpoint.Checkpoint as Checkpoint
import com.kms.katalon.core.cucumber.keyword.CucumberBuiltinKeywords as CucumberKW
import com.kms.katalon.core.mobile.keyword.MobileBuiltInKeywords as Mobile
import com.kms.katalon.core.model.FailureHandling as FailureHandling
import plp.Resources
import org.testng.Assert
import org.openqa.selenium.WebDriver
import com.kms.katalon.core.webui.driver.DriverFactory as DriverFactory
import com.kms.katalon.core.testcase.TestCase as TestCase
import com.kms.katalon.core.testdata.TestData as TestData
import com.kms.katalon.core.testobject.TestObject as TestObject
import com.kms.katalon.core.webservice.keyword.WSBuiltInKeywords as WS
import com.kms.katalon.core.webui.keyword.WebUiBuiltInKeywords as WebUI
import internal.GlobalVariable as GlobalVariable



//@Author: Amit Baghel.
//Date : 14/9/2019


int i=3;

//boolean result=Resources.selectCityPopup();
//
//Assert.assertFalse(result);

//Getting the Driver Object.
WebDriver driver= DriverFactory.getWebDriver();

//Moving the mouse cursor to the Header of the Page.
WebUI.mouseOver(findTestObject("Object Repository/PLPpage/PLP_Title"));


//Getting the Total Count of Products on the Page.
int totalProducts = Resources.getTotalCount();

//Getting the Lower and Higher Range.
List<String> emiPrice=new ArrayList<>();

//Updating the ArrayList with all the EMI prices.
emiPrice.addAll(Resources.getallEMIValues(i,totalProducts));


println(emiPrice);

//Checking the List if the prices are according to the Ascending order.
for(int j=0;j<emiPrice.size()-1;j++){
	int k=j+1;
	if(emiPrice.get(j)<=emiPrice.get(k)){
		continue;
	}else{
	Assert.assertFalse(true);
	}
}



//println(arr.get(0));
//println(arr.get(1));
//
//arr.set(0, arr.get(0).replace(',',''));
//arr.set(1, arr.get(1).replace(',',''));
//
////Getting in specific variables rather than using the Array.
//int lower=Integer.valueOf(arr.get(0))
//int higher=Integer.valueOf(arr.get(1));
//
//boolean flag=false;
//for(int i=0;i<=totalProducts;i++){
//	String productEMI=WebUI.getText(findTestObject("Object Repository/FilterButtons/EMIOfProduct"))
//	String[] gettingDigit=productEMI.split("\\.");
//	gettingDigit[1]=gettingDigit[1].replaceAll(',','');
//	int value=Integer.parseInt(gettingDigit[1]);
//	if(value>=lower && value<=higher){
//		flag=true;
//		lower=value;
//		continue;
//	}else{
//	 flag=false;
//	}
//}








 