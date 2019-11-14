package plp

import static com.kms.katalon.core.checkpoint.CheckpointFactory.findCheckpoint
import static com.kms.katalon.core.testcase.TestCaseFactory.findTestCase
import static com.kms.katalon.core.testdata.TestDataFactory.findTestData
import static com.kms.katalon.core.testobject.ObjectRepository.findTestObject
import java.lang.String
import org.testng.Assert
import org.openqa.selenium.WebDriver
import org.openqa.selenium.By
import org.openqa.selenium.interactions.Actions
import org.openqa.selenium.WebElement
import org.openqa.selenium.chrome.ChromeDriver
import com.kms.katalon.core.annotation.SetUp
import com.kms.katalon.core.annotation.Keyword
import com.kms.katalon.core.checkpoint.Checkpoint
import com.kms.katalon.core.cucumber.keyword.CucumberBuiltinKeywords as CucumberKW
import com.kms.katalon.core.mobile.keyword.MobileBuiltInKeywords as Mobile
import pom_files.PLPFilterOptions
import com.kms.katalon.core.model.FailureHandling
import com.kms.katalon.core.testcase.TestCase
import com.kms.katalon.core.testdata.TestData
import com.kms.katalon.core.testobject.TestObject
import com.kms.katalon.core.webservice.keyword.WSBuiltInKeywords as WS
import com.kms.katalon.core.webui.driver.DriverFactory
import com.kms.katalon.core.webui.keyword.WebUiBuiltInKeywords as WebUI

import internal.GlobalVariable


//@Author: Amit Baghel.
public class Resources {

	static Map<String, String> reviews;
	static WebDriver driver;
	static ArrayList<String> windowIds;
	static ArrayList<String> namesofProducts;
	static int total;
	static boolean selectCity=false;


	public Resources(){
		reviews=new HashMap<String,String>();
		windowIds=new LinkedHashSet<String>();
	}

	@Keyword
	//Getting all the window Handles..
	public static void getWindowHandle(){
		windowIds.add(WebUI.getWindowIndex());
	}

	@Keyword
	public static int getListofProducts(){
		int list=driver.findElements(By.xpath("//div[@class='mst-searchautocomplete__wrapper']/div/div/div[1]/ul/li")).size();
		return list;
	}

	@Keyword
	//Check if the Compare Popup is Displayed on the Page.
	public static boolean checkifComparepopuppresent(){
		//Just a Verification code that im writing for debugging Purpose.
		WebDriver driver =DriverFactory.getWebDriver();
		boolean result=driver.findElement(By.xpath("//button[@class='compareBTN']")).isDisplayed();
		return result;
	}

	//Maximizing the browser.
	@Keyword
	public static void maximizeBrowser(){
		WebUI.maximizeWindow();
	}

	// Used to check if the Filter and the Cross button are working appropriately.
	@Keyword
	public static void checkFilterButtons(){
		initializeDriver();
		WebUI.click(findTestObject("Object Repository/FilterButtons/a_Filter"))
		Thread.sleep(2000)
		WebUI.waitForElementPresent(findTestObject("Object Repository/FilterButtons/img"), 5)
		WebUI.click(findTestObject("Object Repository/FilterButtons/img"))
	}


	//This is used to initialize the driver that has been created.
	@Keyword
	public static void initializeDriver(){
		driver=DriverFactory.getWebDriver();
		namesofProducts=new ArrayList<String>();
	}

	@Keyword
	public static void incrementnoOfProducts(){
		GlobalVariable.nosOfProducts++;
	}

	@Keyword
	public  static int nosOfProductsonComparePage(WebDriver driver){
		int elements = driver.findElements(By.className('p_designbox')).size();
		return elements;
	}



	//In this Function we will be verifying the Category and Brand Filters.
	@Keyword
	public static void verifyFilter(){
		Thread.sleep(2000)
		WebUI.click(findTestObject("Object Repository/FilterButtons/a_Filter"))
		Thread.sleep(2000)
		WebUI.scrollToElement(findTestObject("Object Repository/FilterButtons/PrimaryCamera"),5)
		WebUI.scrollToElement(findTestObject("Object Repository/FilterButtons/div_Brand"), 5)
		WebUI.click(findTestObject("Object Repository/FilterButtons/div_Brand"))
		//WebUI.setText(findTestObject("Object Repository/FilterButtons/input_Below 2 MP_layer-search-box"),"LG")
		Thread.sleep(2000);
		WebUI.click(findTestObject("Object Repository/FilterButtons/label_LG"))
		WebUI.click(findTestObject("Object Repository/FilterButtons/ApplyButton"))
	}

	//This is used to move the EMI slider to a Random Location.
	@Keyword
	public static void moveSlider(){
		WebUI.dragAndDropByOffset(findTestObject("Object Repository/FilterButtons/EmiSliderButton"), 100,200)
	}


	//Used to get the Total count of the products that are being displayed.
	@Keyword
	public static int getTotalCount(){
		String productCount = WebUI.getText(findTestObject('Object Repository/PLPpage/TotalObjects'))

		String [] s = productCount.split(" ");

		int totalProductCount = Integer.valueOf(s[1]);

		return totalProductCount;
	}

	@Keyword
	public static int VerifyEmiRangeTotalCount(){
		String productCount = WebUI.getText(findTestObject('Object Repository/FilterButtons/EMIRangeTotalCount'))

		String[] s = productCount.split(" ");

		int totalProductCount = Integer.valueOf(s[1]);

		return totalProductCount;
	}



	//To store all the EMIs of the product on the PLP page.
	@Keyword
	public static ArrayList<String> getallEMIValues(int i,int totalProducts){
		List<String> arr=new ArrayList<>();
		initializeDriver();
		Actions a=new Actions(driver);
		ArrayList<String> emiPrice=new ArrayList<>();
		int j=1,total=1;

		while(total<=totalProducts){


			int size=driver.findElements(By.xpath("//div[@id='layer-product-list']/div["+i+"]/ol/li")).size();

			a.moveToElement(driver.findElement(By.xpath("(//div[@class='product-item-inner-details']/div[1]/h4)["+total+"]"))).build().perform();

			//Getting the Complete text of the EMI.
			emiPrice.add(driver.findElement(By.xpath("(//div[@class='product-item-inner-details']/div[1]/h4)["+total+"]")).getText());

			//Here we are Partitioning the EMI that has been stored.
			String[] s=emiPrice.get(total-1).split("/");

			//Here we are replacing all the , in the Amount with NUll.
			s[0]=s[0].replaceAll(",","");

			//Here we are adding the EMI actual price to the Global ArrayList Object arr...
			arr.add(Integer.parseInt(s[0].substring(1)));

			total++;

			i++;

		}
		return arr;
	}


	@Keyword
	public static void goToWishList(){
		WebUI.click(findTestObject("Object Repository/MyAccount/MyWishList"))
	}

	@Keyword
	public static void removeProductsFromWishlist(int count){
		for(int i=0;i<count;i++){
			WebUI.click(findTestObject("Object Repository/WishList/EachItemOnWishListPage"))
			WebUI.click(findTestObject("Object Repository/WishList/WishListButtonPDPPage"))
			WebUI.back();
		}
	}

	@Keyword
	public static void addProductstowishList(){
		WebUI.click(findTestObject("Object Repository/WishList/WishListIconPLPage"));
	}

	@Keyword
	public static void addProductstoWishListfromPDPPage(){
		WebUI.click(findTestObject("Object Repository/WishList/WishListButtonPDPPage"))
	}

	@Keyword
	public static void movingToSmartphonesPage(){
		WebUI.click(findTestObject("Object Repository/Category_Traverse/Categories"))

		WebUI.waitForElementClickable(findTestObject("Object Repository/Category_Traverse/Mobile and Electronics"), 5)

		WebUI.click(findTestObject("Object Repository/Category_Traverse/Mobile and Electronics"))
	}

	@Keyword
	public static void moveToMobiles(){
		WebUI.click(findTestObject("Object Repository/Category_Traverse/Categories"));

		WebUI.waitForElementClickable(findTestObject("Object Repository/Category_Traverse/Mobile and Electronics"), 5)

		WebUI.mouseOver(findTestObject("Object Repository/Category_Traverse/Mobile and Electronics"))

		WebUI.click(findTestObject("Object Repository/Category_Traverse/Mobiles"));


	}


	@Keyword
	public static void selectCity(){

		WebUI.click(findTestObject("Object Repository/Login/CitySelection"));
		selectCity=true;
	}


	//Used to check if the City pop up is appearing on the Page.
	public static boolean selectCityPopup(){

		boolean flag=WebUI.waitForElementPresent(findTestObject("Object Repository/SelectCity/SelectCityPopup"),3);

		println(flag);

		return flag;
	}

	//Verifying the 30 product Lazy load Count.
	public static int verifyLoadCount(int i,int totalProductCount,CountProducts count){
		int total1;
		initializeDriver();
		int incrementCount=0,size;
		boolean flag=true;
		while(flag){
			total1=total1 + count.countProducts(i);

			println(total1);

			int j=1;

			if(total%30==incrementCount && total<=totalProductCount){

				Actions a=new Actions(driver);

				WebUI.waitForElementNotPresent(findTestObject("Object Repository/PLPpage/LoadElement"), 10);

				size=driver.findElements(By.xpath("//div[@id='layer-product-list']/div["+i+"]/ol/li")).size();

				//If lazy loading is not working than Script will break and throw the appropriate Assertion....
				if(size==0 && total!=totalProductCount){
					flag=false;
					break;
				}

				WebElement Scroll=driver.findElement(By.xpath("//div[@id='layer-product-list']/div["+i+"]/ol/li["+size+"]"));

				a.moveToElement(Scroll).build().perform();

				i++;
			}else{

				flag=false;

			}
		}

		return total1;
	}


	public static boolean verifyProductNames(String name){

		println(name);

		int totalCount=Resources.getTotalCount();

		int j=3;

		WebUI.mouseOver(findTestObject("Object Repository/PLPpage/PLP_Title"));

		PLPFilterOptions ob=new PLPFilterOptions(driver);

		for(int i=1;i<=totalCount;i++){

			String s=driver.findElement(By.xpath("(//a[@class='product-item-link'])["+i+"]")).getText();

			String s1 =WebUI.getText(findTestObject("Object Repository/PLPpage/productNames"));

			Assert.assertTrue(s1.contains(name));


		}
	}


}
