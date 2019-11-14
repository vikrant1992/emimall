import static com.kms.katalon.core.checkpoint.CheckpointFactory.findCheckpoint
import static com.kms.katalon.core.testcase.TestCaseFactory.findTestCase
import static com.kms.katalon.core.testdata.TestDataFactory.findTestData
import static com.kms.katalon.core.testobject.ObjectRepository.findTestObject
import com.kms.katalon.core.checkpoint.Checkpoint as Checkpoint
import plp.Resources
import org.openqa.selenium.WebDriver
import org.testng.Assert
import org.junit.After
import org.openqa.selenium.By
import org.openqa.selenium.WebDriver
import com.kms.katalon.core.cucumber.keyword.CucumberBuiltinKeywords as CucumberKW
import com.kms.katalon.core.mobile.keyword.MobileBuiltInKeywords as Mobile
import com.kms.katalon.core.model.FailureHandling as FailureHandling
import com.kms.katalon.core.testcase.TestCase as TestCase
import com.kms.katalon.core.testdata.TestData as TestData
import com.kms.katalon.core.testobject.TestObject as TestObject
import com.kms.katalon.core.webservice.keyword.WSBuiltInKeywords as WS
import com.kms.katalon.core.webui.driver.DriverFactory
import com.kms.katalon.core.webui.keyword.WebUiBuiltInKeywords as WebUI
import internal.GlobalVariable as GlobalVariable



//@Author : Amit Baghel.
String parentID,chilId,productName,productReview;

//Creating object of the Reviews Class.
Resources review=new Resources();

int i=0;

WebUI.executeJavaScript('window.open();', [])

WebDriver driver=DriverFactory.getWebDriver();

Set<String> s1=driver.getWindowHandles();

Iterator<String> list=s1.iterator();

String[] arr=s1.toArray();

parentID=arr[0];
childId=arr[1];

//Either of the command would work if used..
//WebUI.switchToWindowIndex(1);
driver.switchTo().window(childId);

WebUI.navigateToUrl(GlobalVariable.AdminURL)

WebUI.click(findTestObject('Object Repository/Page_Magento Admin/body_requireconfig'))

WebUI.setText(findTestObject('Object Repository/Page_Magento Admin/input_Username_loginusername'),GlobalVariable.AdminUN)

//WebUI.click(findTestObject('Object Repository/Page_Magento Admin/section_requireconfig'))

WebUI.setText(findTestObject('Object Repository/Page_Magento Admin/input_Password_loginpassword'),GlobalVariable.AdminPass)

//WebUI.click(findTestObject('Object Repository/Page_Magento Admin/section_requireconfig'))

WebUI.click(findTestObject('Object Repository/Page_Magento Admin/span_Sign in'))

Resources.maximizeBrowser();

//Now just clicking on close button if it is present.
if(driver.findElements(By.xpath("(//button[@class='action-close'])[1]")).size()>0){
	
	Thread.sleep(2000);
	
	driver.findElement(By.xpath("(//button[@class='action-close'])[1]")).click();
}

Thread.sleep(3000)

WebUI.click(findTestObject('Object Repository/Page_Dashboard  Magento Admin/a_Marketing'))

//Thread.sleep(2000);

WebUI.waitForElementNotClickable(findTestObject('Object Repository/Page_Dashboard  Magento Admin/span_Reviews'), 5)

WebUI.click(findTestObject('Object Repository/Page_Dashboard  Magento Admin/span_Reviews'))

WebUI.selectOptionByIndex(findTestObject("Page_Reviews_Admin/select_ApprovedPendingNot Approved"), 2)

WebUI.click(findTestObject("Page_Reviews_Admin/Search"))



//Navigating to the Review Page of the Product and Approving it.
 productName=WebUI.getText(findTestObject("Page_Reviews_Admin/ProductName"))
 productReview=WebUI.getText(findTestObject("Object Repository/Page_Reviews_Admin/ProductReview"))


//Inserting data in Map.
review.reviews.put(productName, productReview);

//Displaying the data from MAP.
Iterator<HashMap<String,String>> itr=review.reviews.entrySet().iterator();

//Currently just used for Debugging purpose...
while(itr.hasNext()){
	println(itr.next());
}

//Now approving the Review that has been written..
WebUI.click(findTestObject("Object Repository/WriteReview/AdminPanelReviewEditButton"))

WebUI.selectOptionByValue(findTestObject("Object Repository/WriteReview/SelectDropDown"),"1", false)

productReview=WebUI.getText(findTestObject("Object Repository/WriteReview/ReviewonEditPage"))

WebUI.click(findTestObject("Object Repository/WriteReview/SaveButton"))

println(productReview);

review.reviews.put(productName, productReview)

//Now switching back the WebUI to the parent window.
//WebUI.switchToWindowIndex(0);This command too would work just trying some fancy selenium stuff.
driver.switchTo().window(parentID);

//Refreshing the Browser.
WebUI.refresh();

//Now just checking the Review against the Product name.
String reviewdescription=WebUI.getText(findTestObject("Object Repository/WriteReview/DescriptionOfWrittenReview"));

//Now verifying the Description..
Assert.assertEquals(reviewdescription,review.reviews.get(productName))






